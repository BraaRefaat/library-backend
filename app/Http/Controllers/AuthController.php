<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use App\Models\PasswordReset;

class AuthController
{
    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        // Ensure name is properly formatted
        $request->merge([
            'U_name' => trim($request->U_name)
        ]);

        $validated = $request->validate([
            'U_name' => 'required|string|max:255',
            'U_Mail' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                'regex:/^[A-Za-z0-9._%+-]+@edu\.aun\.edu\.eg$/'
            ],
            'password' => 'required|string|min:8|confirmed',
        ], [
            'U_Mail.required' => 'البريد الإلكتروني مطلوب',
            'U_Mail.email' => 'صيغة البريد الإلكتروني غير صحيحة',
            'U_Mail.unique' => 'هذا البريد الإلكتروني مسجل بالفعل',
            'U_Mail.regex' => 'يجب أن يكون البريد الإلكتروني من نطاق @edu.aun.edu.eg',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'يجب أن تكون كلمة المرور 8 أحرف على الأقل',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'طالب'; // Ensure exact match with enum values

        $user = User::create($validated);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'تم تسجيل المستخدم بنجاح'
        ], 201);
    }

    /**
     * Login user and create token
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'U_Mail' => [
                'required',
                'email',
                'regex:/^[A-Za-z0-9._%+-]+@edu\.aun\.edu\.eg$/'
            ],
            'password' => 'required|string',
        ], [
            'U_Mail.required' => 'البريد الإلكتروني مطلوب',
            'U_Mail.email' => 'صيغة البريد الإلكتروني غير صحيحة',
            'U_Mail.regex' => 'يجب أن يكون البريد الإلكتروني من نطاق @edu.aun.edu.eg',
            'password.required' => 'كلمة المرور مطلوبة',
        ]);

        if (!Auth::attempt(['U_Mail' => $validated['U_Mail'], 'password' => $validated['password']])) {
            throw ValidationException::withMessages([
                'U_Mail' => ['.إن بيانات المستخدم المقدمة غير صحيحة'],
            ]);
        }

        $user = User::where('U_Mail', $validated['U_Mail'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'تم تسجيل الدخول بنجاح'
        ]);
    }

    /**
     * Logout user (revoke token)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'تم تسجيل الخروج بنجاح'
        ]);
    }

    /**
     * Get the authenticated user
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Send password reset link
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'U_Mail' => [
                'required',
                'email',
                'regex:/^[A-Za-z0-9._%+-]+@edu\\.aun\\.edu\\.eg$/'
            ],
        ]);

        // Find the user by email
        $user = User::where('U_Mail', $request->U_Mail)->first();

        if (!$user) {
            // Don't reveal that the user doesn't exist for security reasons
            return response()->json([
                'message' => 'تم إرسال رابط إعادة تعيين كلمة المرور إلى بريدك الإلكتروني إذا كان الحساب موجودًا.'
            ]);
        }

        // Create a password reset token manually
        $token = bin2hex(random_bytes(32));

        // Delete any existing reset tokens for this email
        PasswordReset::where('U_Mail', $request->U_Mail)->delete();

        // Create new reset token
        PasswordReset::create([
            'U_Mail' => $request->U_Mail,
            'token' => $token,
            'created_at' => now()
        ]);

        // Dispatch the custom job to send the email
        \App\Jobs\SendPasswordResetEmailJob::dispatch($request->U_Mail, $token);

        return response()->json([
            'message' => 'تم إرسال رابط إعادة تعيين كلمة المرور إلى بريدك الإلكتروني.'
        ]);
    }

    /**
     * Reset user password using U_Mail and token
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'U_Mail' => [
                'required',
                'email',
                'regex:/^[A-Za-z0-9._%+-]+@edu\.aun\.edu\.eg$/'
            ],
            'token' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Find the password reset record
        $passwordReset = PasswordReset::where('U_Mail', $request->U_Mail)
            ->where('token', $request->token)
            ->first();

        if (!$passwordReset) {
            return response()->json(['message' => 'رمز إعادة تعيين كلمة المرور غير صالح أو منتهي الصلاحية.'], 400);
        }

        // Check if token is expired (tokens older than 60 minutes are invalid)
        $tokenCreatedAt = \Carbon\Carbon::parse($passwordReset->created_at);
        if ($tokenCreatedAt->diffInMinutes(now()) > 60) {
            $passwordReset->delete();
            return response()->json(['message' => 'رمز إعادة تعيين كلمة المرور منتهي الصلاحية. يرجى طلب رمز جديد.'], 400);
        }

        // Find the user
        $user = User::where('U_Mail', $request->U_Mail)->first();
        if (!$user) {
            return response()->json(['message' => 'المستخدم غير موجود.'], 404);
        }

        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the reset token
        $passwordReset->delete();

        return response()->json(['message' => 'تم تغيير كلمة المرور بنجاح.']);
    }
}

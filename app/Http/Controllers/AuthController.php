<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use App\Models\PasswordReset;

class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'U_name' => 'required|string|max:255',
            'U_Mail' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                'regex:/^[A-Za-z0-9._%+-]+@aun\.edu\.eg$/'
            ],
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'student'; // Set default role

        $user = User::create($validated);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'User registered successfully'
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
                'regex:/^[A-Za-z0-9._%+-]+@aun\.edu\.eg$/'
            ],
            'password' => 'required|string',
        ]);

        if (!Auth::attempt(['U_Mail' => $validated['U_Mail'], 'password' => $validated['password']])) {
            throw ValidationException::withMessages([
                'U_Mail' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = User::where('U_Mail', $validated['U_Mail'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Login successful'
        ]);
    }

    /**
     * Logout user (revoke token)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
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
                'regex:/^[A-Za-z0-9._%+-]+@aun\\.edu\\.eg$/'
            ],
        ]);

        // Override the email field for the password broker
        $status = Password::broker()->sendResetLink(
            ['U_Mail' => $request->U_Mail]
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'تم إرسال رابط إعادة تعيين كلمة المرور إلى بريدك الإلكتروني.'])
            : response()->json(['message' => 'حدث خطأ أثناء إرسال الرابط.'], 400);
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
                'regex:/^[A-Za-z0-9._%+-]+@aun\\.edu\\.eg$/'
            ],
            'token' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $passwordReset = PasswordReset::where('U_Mail', $request->U_Mail)
            ->where('token', $request->token)
            ->first();

        if (!$passwordReset) {
            return response()->json(['message' => 'رمز إعادة تعيين كلمة المرور غير صالح أو منتهي الصلاحية.'], 400);
        }

        $user = User::where('U_Mail', $request->U_Mail)->first();
        if (!$user) {
            return response()->json(['message' => 'المستخدم غير موجود.'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the reset token
        $passwordReset->delete();

        return response()->json(['message' => 'تم تغيير كلمة المرور بنجاح.']);
    }
}

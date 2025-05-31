<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>إعادة تعيين كلمة المرور</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 20px auto; text-align: center; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        h1 { color: #333333; text-align: center; margin-bottom: 20px; }
        p { color: #666666; margin-bottom: 15px; }
        .button { display: inline-block; background-color: #007bff; color: #ffffff !important; text-decoration: none; padding: 10px 20px; border-radius: 5px; }
        .footer { margin-top: 20px; text-align: center; font-size: 0.9em; color: #999999; }
    </style>
</head>
<body>
    <div class="container" dir="rtl">
        <h1>إعادة تعيين كلمة المرور</h1>

        <p>أنت تتلقى هذا البريد الإلكتروني لأننا تلقينا طلبًا لإعادة تعيين كلمة المرور لحسابك.</p>

        <p style="text-align: center;">
            <a href="{{ $resetUrl }}" class="button">إعادة تعيين كلمة المرور</a>
        </p>

        <p>هذا الرابط سينتهي صلاحيته في 60 دقيقة.</p>

        <p>إذا لم تطلب إعادة تعيين كلمة المرور، فلا يلزم اتخاذ أي إجراء آخر.</p>

        <hr>

        <p class="footer">© {{ date('Y') }} {{ config('app.name') }}. جميع الحقوق محفوظة.</p>
    </div>
</body>
</html>

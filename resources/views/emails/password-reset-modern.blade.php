<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>إعادة تعيين كلمة المرور</title>
    <style>
        /* Reset and base styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #2d3748;
        }

        /* Container styles */
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        /* Header styles */
        .header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            padding: 40px 20px;
            text-align: center;
        }

        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }

        /* Content styles */
        .content {
            padding: 40px 30px;
            text-align: right;
        }

        p {
            margin-bottom: 20px;
            font-size: 16px;
            color: #4a5568;
            line-height: 1.8;
        }

        /* Button styles */
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            transition: transform 0.2s ease;
            box-shadow: 0 4px 6px rgba(79, 70, 229, 0.2);
        }

        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(79, 70, 229, 0.3);
        }

        /* Divider styles */
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e2e8f0, transparent);
            margin: 30px 0;
        }

        /* Footer styles */
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #ffffff;
            color: #64748b;
            font-size: 14px;
            border-top: 1px solid #e2e8f0;
        }

        /* Warning text styles */
        .warning-text {
            color: #ef4444;
            font-size: 14px;
            margin-top: 30px;
            padding: 15px;
            background-color: #fef2f2;
            border-radius: 8px;
            border-right: 4px solid #ef4444;
        }

        /* Logo placeholder */
        .logo {
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 150px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>إعادة تعيين كلمة المرور</h1>
        </div>

        <div class="content">
            <p>مرحباً،</p>

            <p>أنت تتلقى هذا البريد الإلكتروني لأننا تلقينا طلباً لإعادة تعيين كلمة المرور لحسابك.</p>

            <div style="text-align: center;">
                <a href="{{ $resetUrl }}" class="button">إعادة تعيين كلمة المرور</a>
            </div>

            <p>هذا الرابط سينتهي صلاحيته في 60 دقيقة.</p>

            <div class="warning-text">
                إذا لم تطلب إعادة تعيين كلمة المرور، فلا يلزم اتخاذ أي إجراء آخر.
            </div>
        </div>

        <div class="divider"></div>

        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. جميع الحقوق محفوظة.</p>
        </div>

        <!-- <div class="logo">
            <img src="{{ asset('images/library-logo.png') }}" alt="EDU Library Logo">
        </div> -->
    </div>
</body>
</html>

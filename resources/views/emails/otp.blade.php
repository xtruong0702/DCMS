<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mã OTP đặt lại mật khẩu</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 20px;
            color: #334155;
        }
        .container {
            max-width: 560px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }
        .header {
            background: linear-gradient(135deg, #0284c7 0%, #06b6d4 100%);
            padding: 30px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .header p {
            margin: 8px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .body {
            padding: 32px 28px;
        }
        .greeting {
            font-size: 16px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 12px;
        }
        .text {
            font-size: 14px;
            line-height: 1.6;
            color: #475569;
            margin-bottom: 24px;
        }
        .otp-box {
            background: #f0f9ff;
            border: 2px dashed #38bdf8;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            margin: 24px 0;
        }
        .otp-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #0369a1;
            margin-bottom: 8px;
        }
        .otp-code {
            font-family: 'Courier New', Courier, monospace;
            font-size: 36px;
            font-weight: 800;
            color: #0284c7;
            letter-spacing: 8px;
            margin: 6px 0;
        }
        .otp-expiry {
            font-size: 13px;
            color: #64748b;
            margin-top: 8px;
        }
        .note {
            background-color: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 12px 16px;
            border-radius: 4px;
            font-size: 13px;
            color: #92400e;
            line-height: 1.5;
            margin-top: 20px;
        }
        .footer {
            background-color: #f8fafc;
            padding: 20px 28px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #94a3b8;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>NHA KHOA SMILE</h1>
            <p>Hệ thống Quản lý Khám chữa bệnh DCMS</p>
        </div>
        <div class="body">
            <div class="greeting">Xin chào {{ $name }},</div>
            <div class="text">
                Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn tại hệ thống Nha Khoa Smile. Vui lòng sử dụng mã xác thực OTP bên dưới để hoàn tất việc đổi mật khẩu:
            </div>

            <div class="otp-box">
                <div class="otp-label">Mã xác thực OTP của bạn</div>
                <div class="otp-code">{{ $otp }}</div>
                <div class="otp-expiry">Mã này có hiệu lực trong vòng <strong>15 phút</strong>.</div>
            </div>

            <div class="note">
                <strong>Lưu ý bảo mật:</strong> Không cung cấp mã OTP này cho bất kỳ ai, kể cả nhân viên phòng khám. Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email và tài khoản của bạn vẫn an toàn.
            </div>
        </div>
        <div class="footer">
            <p style="margin: 0 0 4px 0;"><strong>Nha Khoa Smile</strong> - Chăm sóc nụ cười gia đình bạn</p>
            <p style="margin: 0;">Hotline: 1900 8888 | Email hỗ trợ: support@nhakhoasmile.vn</p>
        </div>
    </div>
</body>
</html>


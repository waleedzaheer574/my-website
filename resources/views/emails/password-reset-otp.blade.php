<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Password reset OTP</title>
</head>
<body style="margin:0;background:#eef6ff;font-family:Arial,sans-serif;color:#0f172a;">
  <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#eef6ff;padding:28px 14px;">
    <tr>
      <td align="center">
        <table width="560" cellpadding="0" cellspacing="0" role="presentation" style="max-width:560px;background:#ffffff;border-radius:22px;overflow:hidden;border:1px solid #bae6fd;">
          <tr>
            <td style="background:#020617;padding:28px 32px;color:#ffffff;">
              <div style="font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#38bdf8;font-weight:700;">Multitechwave</div>
              <h1 style="margin:10px 0 0;font-size:26px;">Password Reset OTP</h1>
            </td>
          </tr>
          <tr>
            <td style="padding:30px 32px;">
              <p style="margin:0 0 16px;line-height:1.7;">Hi {{ $user->name }},</p>
              <p style="margin:0 0 18px;line-height:1.7;">Use this one-time password to reset your account password:</p>
              <div style="background:#e0f2fe;border-radius:18px;padding:20px;text-align:center;font-size:32px;font-weight:700;letter-spacing:8px;color:#0369a1;">
                {{ $otp }}
              </div>
              <p style="margin:20px 0 0;color:#64748b;line-height:1.7;">This OTP will expire in 10 minutes. If you did not request this, you can ignore this email.</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>

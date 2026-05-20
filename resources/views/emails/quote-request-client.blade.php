<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Quote request received</title>
</head>
<body style="margin:0;background:#eef6ff;font-family:Arial,sans-serif;color:#0f172a;">
  <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#eef6ff;padding:28px 14px;">
    <tr>
      <td align="center">
        <table width="620" cellpadding="0" cellspacing="0" role="presentation" style="max-width:620px;background:#ffffff;border-radius:22px;overflow:hidden;border:1px solid #bae6fd;">
          <tr>
            <td style="background:#020617;padding:30px 34px;color:#ffffff;">
              <div style="font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#38bdf8;font-weight:700;">Multitechwave</div>
              <h1 style="margin:10px 0 0;font-size:28px;line-height:1.2;">Your request has been submitted</h1>
            </td>
          </tr>
          <tr>
            <td style="padding:30px 34px;">
              <p style="margin:0 0 16px;font-size:16px;line-height:1.7;">Hi {{ $quote->client_name }},</p>
              <p style="margin:0 0 18px;font-size:16px;line-height:1.7;">
                Thank you for requesting a quote from Multitechwave. Your request has been submitted successfully. Our team will review it, take action on it, and inform you very soon.
              </p>
              <div style="background:#e0f2fe;border-radius:18px;padding:20px;margin:24px 0;">
                <p style="margin:0 0 8px;color:#0369a1;font-weight:700;">Reference</p>
                <h2 style="margin:0;font-size:24px;color:#020617;">{{ $quote->reference }}</h2>
              </div>
              <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                  <td style="padding:12px;border-bottom:1px solid #e2e8f0;color:#64748b;">Service</td>
                  <td style="padding:12px;border-bottom:1px solid #e2e8f0;font-weight:700;">{{ $quote->service_title }}</td>
                </tr>
                <tr>
                  <td style="padding:12px;border-bottom:1px solid #e2e8f0;color:#64748b;">Budget</td>
                  <td style="padding:12px;border-bottom:1px solid #e2e8f0;font-weight:700;">{{ $quote->budget_label }}</td>
                </tr>
                <tr>
                  <td style="padding:12px;color:#64748b;">Timeline</td>
                  <td style="padding:12px;font-weight:700;">{{ $quote->timeline_label }}</td>
                </tr>
              </table>
              <p style="margin:24px 0 0;font-size:14px;line-height:1.7;color:#64748b;">Regards,<br>Multitechwave Team</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>

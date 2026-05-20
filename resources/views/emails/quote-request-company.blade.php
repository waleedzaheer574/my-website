<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>New quote request</title>
</head>
<body style="margin:0;background:#f8fafc;font-family:Arial,sans-serif;color:#0f172a;">
  <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#f8fafc;padding:28px 14px;">
    <tr>
      <td align="center">
        <table width="660" cellpadding="0" cellspacing="0" role="presentation" style="max-width:660px;background:#ffffff;border-radius:22px;overflow:hidden;border:1px solid #bae6fd;">
          <tr>
            <td style="background:#020617;padding:30px 34px;color:#ffffff;">
              <div style="font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#38bdf8;font-weight:700;">New Quote Request</div>
              <h1 style="margin:10px 0 0;font-size:28px;line-height:1.2;">{{ $quote->reference }}</h1>
            </td>
          </tr>
          <tr>
            <td style="padding:30px 34px;">
              <p style="margin:0 0 18px;font-size:16px;line-height:1.7;">
                A new quote request has been submitted on the website. Please check it and follow up with the client.
              </p>
              <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin:20px 0;">
                <tr>
                  <td style="padding:12px;border-bottom:1px solid #e2e8f0;color:#64748b;">Client</td>
                  <td style="padding:12px;border-bottom:1px solid #e2e8f0;font-weight:700;">{{ $quote->client_name }}</td>
                </tr>
                <tr>
                  <td style="padding:12px;border-bottom:1px solid #e2e8f0;color:#64748b;">Company</td>
                  <td style="padding:12px;border-bottom:1px solid #e2e8f0;font-weight:700;">{{ $quote->company_name ?: 'N/A' }}</td>
                </tr>
                <tr>
                  <td style="padding:12px;border-bottom:1px solid #e2e8f0;color:#64748b;">Email</td>
                  <td style="padding:12px;border-bottom:1px solid #e2e8f0;font-weight:700;">{{ $quote->client_email }}</td>
                </tr>
                <tr>
                  <td style="padding:12px;border-bottom:1px solid #e2e8f0;color:#64748b;">Phone</td>
                  <td style="padding:12px;border-bottom:1px solid #e2e8f0;font-weight:700;">{{ $quote->client_phone ?: 'N/A' }}</td>
                </tr>
                <tr>
                  <td style="padding:12px;border-bottom:1px solid #e2e8f0;color:#64748b;">Service</td>
                  <td style="padding:12px;border-bottom:1px solid #e2e8f0;font-weight:700;">{{ $quote->service_title }}</td>
                </tr>
                <tr>
                  <td style="padding:12px;border-bottom:1px solid #e2e8f0;color:#64748b;">Budget</td>
                  <td style="padding:12px;border-bottom:1px solid #e2e8f0;font-weight:700;">{{ $quote->budget_label }}</td>
                </tr>
                <tr>
                  <td style="padding:12px;color:#64748b;">Estimate</td>
                  <td style="padding:12px;font-weight:700;">{{ $quote->estimate_label }}</td>
                </tr>
              </table>
              <div style="background:#f1f5f9;border-radius:16px;padding:18px;">
                <p style="margin:0 0 8px;color:#64748b;font-weight:700;">Requirements</p>
                <p style="margin:0;line-height:1.7;">{{ $quote->requirements }}</p>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>

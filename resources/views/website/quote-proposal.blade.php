<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow, noarchive">
  <title>{{ $quote->reference }} Proposal</title>
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      background: #040816;
      color: #eef3ff;
      font-family: Arial, sans-serif;
    }
    .proposal {
      max-width: 1024px;
      margin: 0 auto;
      min-height: 100vh;
      padding: 34px 52px 26px;
      background:
        radial-gradient(circle at 78% 18%, rgba(111, 58, 255, .24), transparent 24%),
        radial-gradient(circle at 56% 30%, rgba(0, 153, 255, .2), transparent 26%),
        linear-gradient(180deg, #05091b, #040816);
    }
    .topbar, .hero, .meta-grid, .body-grid, .actions-row, .footer {
      position: relative;
      z-index: 1;
    }
    .topbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 18px;
      margin-bottom: 30px;
    }
    .brand strong {
      display: block;
      font-size: 18px;
      letter-spacing: .08em;
    }
    .brand span {
      color: #39bdf8;
      display: block;
      font-size: 10px;
      letter-spacing: .12em;
      margin-top: 4px;
      text-transform: uppercase;
    }
    .page-pill, .eyebrow, .reference {
      border: 1px solid rgba(115, 140, 255, .26);
      border-radius: 14px;
      background: rgba(255,255,255,.02);
    }
    .page-pill { padding: 12px 18px; }
    .hero {
      display: grid;
      grid-template-columns: minmax(0, 1fr) 320px;
      gap: 36px;
      align-items: center;
      margin-bottom: 28px;
    }
    .eyebrow {
      color: #c6d6ff;
      display: inline-flex;
      font-size: 13px;
      font-weight: 700;
      letter-spacing: .04em;
      padding: 10px 16px;
    }
    h1 {
      font-size: clamp(34px, 5vw, 54px);
      line-height: 1.02;
      margin: 22px 0 18px;
    }
    h1 span {
      background: linear-gradient(90deg, #46b7ff, #955cff);
      -webkit-background-clip: text;
      color: transparent;
    }
    .reference {
      display: inline-block;
      margin-bottom: 18px;
      padding: 14px 18px;
    }
    .reference strong, .reference span { display: block; }
    .reference span, .prepared {
      color: #a8b2d8;
    }
    .prepared b { color: #39bdf8; }
    .investment {
      border: 1px solid rgba(120, 99, 255, .7);
      border-radius: 22px;
      min-height: 280px;
      padding: 34px 24px;
      text-align: center;
      background:
        radial-gradient(circle at 50% 0, rgba(57, 189, 248, .32), transparent 24%),
        linear-gradient(145deg, rgba(11, 18, 43, .98), rgba(17, 12, 52, .96));
      box-shadow: 0 18px 55px rgba(17, 87, 255, .24);
    }
    .investment i {
      align-items: center;
      border-radius: 999px;
      display: inline-flex;
      font-style: normal;
      font-size: 34px;
      height: 82px;
      justify-content: center;
      margin-top: -76px;
      width: 82px;
      background: linear-gradient(135deg, #0ea5e9, #4f46e5);
      box-shadow: 0 0 28px rgba(57, 189, 248, .45);
    }
    .investment span, .investment small { display: block; color: #a8b2d8; }
    .investment span { margin-top: 24px; text-transform: uppercase; }
    .investment strong {
      display: block;
      font-size: 48px;
      margin: 18px 0 12px;
    }
    .investment small {
      border: 1px solid rgba(115, 140, 255, .22);
      border-radius: 999px;
      display: inline-block;
      padding: 10px 18px;
    }
    .meta-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 18px;
      margin-bottom: 22px;
    }
    .card {
      border: 1px solid rgba(78, 122, 255, .34);
      border-radius: 16px;
      background: rgba(7, 15, 36, .86);
      padding: 22px;
    }
    .card span { color: #a8b2d8; display: block; margin-bottom: 10px; }
    .card strong { font-size: 18px; }
    .body-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }
    .panel {
      border: 1px solid rgba(78, 122, 255, .34);
      border-radius: 18px;
      background: rgba(7, 15, 36, .86);
      padding: 24px;
    }
    .panel h2 { margin: 0 0 20px; font-size: 22px; }
    ul { margin: 0; padding-left: 20px; color: #dbe7ff; line-height: 1.8; }
    .stack { display: grid; gap: 20px; }
    .next-steps {
      counter-reset: steps;
      list-style: none;
      padding: 0;
    }
    .next-steps li {
      counter-increment: steps;
      border: 1px solid rgba(78, 122, 255, .22);
      border-radius: 14px;
      margin-bottom: 12px;
      padding: 16px 16px 16px 54px;
      position: relative;
    }
    .next-steps li::before {
      content: counter(steps, decimal-leading-zero);
      left: 16px;
      position: absolute;
      color: #46b7ff;
      font-weight: 700;
    }
    .actions-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 18px;
      margin-top: 22px;
    }
    .actions-row a, .actions > a {
      border-radius: 16px;
      color: #fff;
      font-weight: 800;
      padding: 22px;
      text-align: center;
      text-decoration: none;
    }
    .actions-row a:first-child { background: linear-gradient(90deg, #0ea5e9, #4f46e5); }
    .actions-row a:last-child { border: 1px solid rgba(78, 122, 255, .42); }
    .footer {
      color: #a8b2d8;
      margin-top: 22px;
      text-align: center;
    }
    .actions {
      display: flex;
      justify-content: center;
      gap: 12px;
      margin: 18px auto 36px;
    }
    .actions > a { background: #2563eb; padding: 14px 22px; }
    .success-modal { align-items: center; background: rgba(2, 6, 23, .7); bottom: 0; display: flex; justify-content: center; left: 0; padding: 20px; position: fixed; right: 0; top: 0; z-index: 20; }
    .success-card { background: #fff; border: 1px solid #bae6fd; border-radius: 24px; max-width: 440px; padding: 28px; text-align: center; color: #020617; }
    .success-card i { align-items: center; background: linear-gradient(135deg, #22c55e, #38bdf8); border-radius: 18px; color: #fff; display: inline-flex; font-style: normal; font-weight: 900; height: 58px; justify-content: center; margin-bottom: 16px; width: 58px; }
    .success-card h2 { margin: 0 0 10px; }
    .success-actions { display: flex; gap: 10px; justify-content: center; }
    .success-actions a, .success-actions button { border: 0; border-radius: 999px; cursor: pointer; font-weight: 900; padding: 12px 18px; text-decoration: none; }
    .success-actions a { background: #2563eb; color: #fff; }
    .success-actions button { background: #e0f2fe; color: #0369a1; }
    @media (max-width: 767px) {
      .proposal { padding: 22px 16px; }
      .topbar, .hero { grid-template-columns: 1fr; display: grid; }
      .topbar { justify-items: start; }
      .hero { gap: 24px; }
      .investment { min-height: 0; margin-top: 30px; }
      .meta-grid, .body-grid, .actions-row { grid-template-columns: 1fr; }
      .card, .panel { padding: 18px; }
      .actions { flex-direction: column; padding: 0 16px; }
    }
    @media print {
      body { background: #040816; }
      .proposal { margin: 0; max-width: none; min-height: auto; }
      .actions, .success-modal { display: none; }
    }
  </style>
</head>
<body>
  <article class="proposal">
    <div class="topbar">
      <div class="brand">
        <strong>MULTITECHWAVE</strong>
        <span>Technology. Innovation. Solutions.</span>
      </div>
      <div class="page-pill">Page 1 / 1</div>
    </div>

    <section class="hero">
      <div>
        <div class="eyebrow">4D Proposal UI</div>
        <h1>Premium<br>Project <span>Proposal</span></h1>
        <div class="reference">
          <strong>{{ $quote->reference }}</strong>
          <span>Proposal Reference</span>
        </div>
        <div class="prepared">Prepared for <b>{{ $quote->client_name }}</b>{{ $quote->company_name ? ' at '.$quote->company_name : '' }}</div>
      </div>
      <div class="investment">
        <i>$</i>
        <span>Estimated Investment</span>
        <strong>{{ $quote->estimate_label }}</strong>
        <small>{{ $quote->budget_label }}</small>
      </div>
    </section>

    <section class="meta-grid">
      <div class="card"><span>Service</span><strong>{{ $quote->service_title }}</strong></div>
      <div class="card"><span>Budget</span><strong>{{ $quote->budget_label }}</strong></div>
      <div class="card"><span>Timeline</span><strong>{{ $quote->timeline_label }}</strong></div>
    </section>

    <section class="body-grid">
      <div class="panel">
        <h2>Included Deliverables</h2>
        <ul>
          @foreach($quote->deliverables ?? [] as $deliverable)
            <li>{{ $deliverable }}</li>
          @endforeach
        </ul>
      </div>
      <div class="stack">
        <div class="panel">
          <h2>Assumptions</h2>
          <ul>
            @foreach($quote->assumptions ?? [] as $assumption)
              <li>{{ $assumption }}</li>
            @endforeach
          </ul>
        </div>
        <div class="panel">
          <h2>Next Steps</h2>
          <ul class="next-steps">
            @foreach($quote->next_steps ?? [] as $step)
              <li>{{ $step }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    </section>

    <div class="actions-row">
      <a href="#">Accept Proposal</a>
      <a href="#">Book Discovery Call</a>
    </div>
    <div class="footer">Multitechwave - Technology, Innovation, Solutions</div>
  </article>

  <div class="actions">
    <a href="{{ route('website.quote-generator.download', $quote->public_token) }}">Download PDF</a>
    <a href="{{ route('website.quote-generator.show', $quote->public_token) }}">Back to Quote</a>
  </div>

  @if(request()->boolean('submitted'))
    <div class="success-modal" id="quoteSuccessModal" role="dialog" aria-modal="true" aria-labelledby="quoteSuccessTitle">
      <div class="success-card">
        <i>OK</i>
        <h2 id="quoteSuccessTitle">Quote submitted successfully.</h2>
        <p>Your instant quotation has been saved and the PDF proposal is ready for direct download.</p>
        <div class="success-actions">
          <a href="{{ route('website.quote-generator.download', $quote->public_token) }}">Download PDF</a>
          <button type="button" onclick="document.getElementById('quoteSuccessModal').remove()">Close</button>
        </div>
      </div>
    </div>
  @endif
</body>
</html>

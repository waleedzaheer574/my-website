@if(session('subscription_success'))
  <div class="tcw-subscription-success-pop" data-subscription-success>
    <div class="tcw-subscription-success-card" role="dialog" aria-modal="true" aria-label="Subscription activated">
      <button type="button" class="tcw-subscription-success-close" data-subscription-success-close aria-label="Close success popup">&times;</button>
      <div class="tcw-success-orbit">
        <span></span>
        <i class="fas fa-check"></i>
      </div>
      <small>Payment Successful</small>
      <h2>{{ session('subscription_title', 'Subscription Activated') }}</h2>
      <p>Your subscription is active now. Your project workspace has been created and our team can start tracking it from the dashboard.</p>
      <div class="tcw-success-meta">
        <span>
          <strong>{{ session('subscription_amount', 'Paid') }}</strong>
          <em>Amount received</em>
        </span>
        <span>
          <strong>Active</strong>
          <em>Subscription status</em>
        </span>
      </div>
      <a href="{{ route('user.subscriptions') }}">View Subscription <i class="fas fa-arrow-right"></i></a>
    </div>
  </div>

  <script>
    (() => {
      const popup = document.querySelector('[data-subscription-success]');
      if (!popup) return;

      const close = () => {
        popup.classList.add('is-leaving');
        window.setTimeout(() => popup.remove(), 260);
      };

      popup.querySelector('[data-subscription-success-close]')?.addEventListener('click', close);
      popup.addEventListener('click', (event) => {
        if (event.target === popup) close();
      });
      window.setTimeout(close, 9000);
    })();
  </script>
@endif

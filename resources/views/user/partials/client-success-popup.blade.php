@if(session('subscription_success'))
  <div class="tcw-subscription-success-pop" data-subscription-success>
    <div class="tcw-subscription-success-card" role="dialog" aria-modal="true" aria-label="{{ __('website.client.subscription_activated') }}">
      <button type="button" class="tcw-subscription-success-close" data-subscription-success-close aria-label="{{ __('website.client.close_popup') }}">&times;</button>
      <div class="tcw-success-orbit">
        <span></span>
        <i class="fas fa-check"></i>
      </div>
      <small>{{ __('website.client.payment_successful') }}</small>
      <h2>{{ session('subscription_title', __('website.client.subscription_active')) }}</h2>
      <p>{{ __('website.client.subscription_message') }}</p>
      <div class="tcw-success-meta">
        <span>
          <strong>{{ session('subscription_amount', __('website.client.paid')) }}</strong>
          <em>{{ __('website.client.amount_received') }}</em>
        </span>
        <span>
          <strong>{{ __('website.client.active') }}</strong>
          <em>{{ __('website.client.subscription_status') }}</em>
        </span>
      </div>
      <a href="{{ route('user.subscriptions') }}">{{ __('website.client.view_subscription') }} <i class="fas fa-arrow-right"></i></a>
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

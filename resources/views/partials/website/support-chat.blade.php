@php
  $supportServices = ($websiteServices ?? collect())
    ->take(6)
    ->map(fn ($service) => $service->localized('service_title'))
    ->filter()
    ->values();
  $supportServiceText = $supportServices->isNotEmpty()
    ? $supportServices->implode(', ')
    : __('website.support.services_fallback');
@endphp

<div class="tcw-support-chat" data-support-chat data-endpoint="{{ route('support-chat') }}">
  <button class="tcw-support-chat__toggle" type="button" aria-label="{{ __('website.support.open') }}" aria-expanded="false" data-support-chat-toggle>
    <i class="far fa-comments"></i>
  </button>

  <section class="tcw-support-chat__panel" aria-label="{{ __('website.support.panel') }}" hidden data-support-chat-panel>
    <header class="tcw-support-chat__header">
      <div class="tcw-support-chat__brand">
        <span class="tcw-support-chat__avatar" aria-hidden="true">
          <i class="fas fa-bolt"></i>
        </span>
        <div>
          <strong>Multitechwave</strong>
          <small>{{ __('website.support.online') }}</small>
        </div>
      </div>
      <button type="button" aria-label="{{ __('website.support.close') }}" data-support-chat-close>
        <i class="fas fa-times"></i>
      </button>
    </header>

    <div class="tcw-support-chat__messages" data-support-chat-messages>
      <div class="tcw-support-chat__message tcw-support-chat__message--assistant">
        {{ __('website.support.welcome', ['services' => $supportServiceText]) }}
      </div>
    </div>

    <form class="tcw-support-chat__form" data-support-chat-form>
      <label class="sr-only" for="tcw-support-chat-message">{{ __('website.support.message') }}</label>
      <textarea id="tcw-support-chat-message" name="message" rows="1" maxlength="1000" placeholder="{{ __('website.support.placeholder') }}" required data-support-chat-input></textarea>
      <button type="submit" aria-label="{{ __('website.support.send') }}" data-support-chat-submit>
        <i class="fas fa-paper-plane"></i>
      </button>
    </form>
  </section>
</div>

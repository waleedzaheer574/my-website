@php
  $supportServices = ($websiteServices ?? collect())
    ->take(6)
    ->pluck('service_title')
    ->filter()
    ->values();
  $supportServiceText = $supportServices->isNotEmpty()
    ? $supportServices->implode(', ')
    : 'website design, development, SEO, branding, digital marketing, and business growth';
@endphp

<div class="tcw-support-chat" data-support-chat data-endpoint="{{ route('support-chat') }}">
  <button class="tcw-support-chat__toggle" type="button" aria-label="Open AI support chat" aria-expanded="false" data-support-chat-toggle>
    <i class="far fa-comments"></i>
  </button>

  <section class="tcw-support-chat__panel" aria-label="AI live support chat" hidden data-support-chat-panel>
    <header class="tcw-support-chat__header">
      <div class="tcw-support-chat__brand">
        <span class="tcw-support-chat__avatar" aria-hidden="true">
          <i class="fas fa-bolt"></i>
        </span>
        <div>
          <strong>Multitechwave</strong>
          <small>AI support is online</small>
        </div>
      </div>
      <button type="button" aria-label="Close support chat" data-support-chat-close>
        <i class="fas fa-times"></i>
      </button>
    </header>

    <div class="tcw-support-chat__messages" data-support-chat-messages>
      <div class="tcw-support-chat__message tcw-support-chat__message--assistant">
        Hi! I am Multitechwave's AI assistant. I can help you with {{ $supportServiceText }}, project questions, pricing direction, and getting started with the right solution.
      </div>
    </div>

    <form class="tcw-support-chat__form" data-support-chat-form>
      <label class="sr-only" for="tcw-support-chat-message">Message</label>
      <textarea id="tcw-support-chat-message" name="message" rows="1" maxlength="1000" placeholder="Type your message..." required data-support-chat-input></textarea>
      <button type="submit" aria-label="Send message" data-support-chat-submit>
        <i class="fas fa-paper-plane"></i>
      </button>
    </form>
  </section>
</div>

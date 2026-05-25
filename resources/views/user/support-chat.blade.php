@extends('layouts.website')

@section('title', __('website.client.chat'))
@section('hide_global_faqs', '1')

@push('css')
  <style>
    .tcw-site-header,.cs-preloader,.tcw-footer,.tcw-floating-contact,.tcw-support-chat { display:none !important; }
  </style>
@endpush

@section('content')
  @php($activeClientNav = 'support')
  @php($clientHeaderTitle = __('website.client.chat'))
  @php($clientHeaderSubtitle = __('website.client.support_subtitle'))
  <main class="tcw-client-dashboard tcw-premium-client-dashboard tcw-live-chat-dashboard">
    @include('user.partials.client-sidebar')

    <section class="tcw-client-main">
      @include('user.partials.client-header')

      <div class="tcw-live-chat-layout">
        <section class="tcw-live-chat-panel">
          <div class="tcw-live-chat-welcome" id="support-welcome" @if($conversation->messages->isNotEmpty()) hidden @endif>
            <i class="fas fa-hand-paper"></i>
            <div>
              <strong>{{ __('website.client.hello', ['name' => auth()->user()->name]) }}</strong>
              <span>{{ __('website.client.help_today') }}</span>
              <p>{{ __('website.client.start_conversation') }}</p>
              <time>{{ now()->format('h:i A') }}</time>
            </div>
          </div>

          <div class="tcw-support-messages tcw-live-chat-messages" id="support-messages" data-last-id="{{ $conversation->messages->last()?->id ?? 0 }}">
            @if($conversation->messages->isNotEmpty())
              <div class="tcw-chat-date-separator">{{ $conversation->messages->first()->created_at->locale(app()->getLocale())->translatedFormat('M d, Y') }}</div>
            @endif
            @foreach($conversation->messages as $message)
              <article class="{{ $message->user_id === auth()->id() ? 'is-me' : 'is-other' }}" data-id="{{ $message->id }}">
                @if($message->user_id !== auth()->id())<b>MTW</b>@endif
                <div>
                  <p>{{ $message->body }}</p>
                  <time>{{ $message->created_at->format('h:i A') }}</time>
                </div>
              </article>
            @endforeach
          </div>

          <form class="tcw-live-chat-form" id="support-form" action="{{ route('user.support-chat.store') }}" method="POST">
            @csrf
            <textarea name="body" placeholder="{{ __('website.support.placeholder') }}" required></textarea>
            <button type="submit" aria-label="{{ __('website.support.send') }}"><i class="fas fa-paper-plane"></i></button>
          </form>
        </section>

        <aside class="tcw-live-chat-aside">
          <section>
            <i class="fas fa-headset"></i>
            <div><strong>{{ __('website.client.here_to_help') }}</strong><span>{{ __('website.client.reply_time') }}</span></div>
            <b>{{ __('website.client.online') }}</b>
            <small>9:00 AM - 6:00 PM (Mon - Fri)</small>
          </section>
          <section>
            <h2>{{ __('website.client.quick_help') }}</h2>
            <a href="{{ route('website.contact') }}">{{ __('website.client.how_request') }} <i class="fas fa-arrow-right"></i></a>
            <a href="{{ route('user.service-requests') }}">{{ __('website.client.how_status') }} <i class="fas fa-arrow-right"></i></a>
            <a href="{{ route('website.quote-generator') }}">{{ __('website.client.how_upload') }} <i class="fas fa-arrow-right"></i></a>
            <a href="{{ route('website.quote-generator') }}">{{ __('website.client.billing_help') }} <i class="fas fa-arrow-right"></i></a>
          </section>
        </aside>
      </div>
    </section>
    @include('user.partials.client-mobile-nav')
  </main>
@endsection

@push('js')
  <script>
    (() => {
      const messages = document.getElementById('support-messages');
      const form = document.getElementById('support-form');
      const textarea = form.querySelector('textarea');
      const welcome = document.getElementById('support-welcome');
      let lastId = Number(messages.dataset.lastId || 0);

      const scrollToBottom = (smooth = true) => messages.scrollTo({
        top: messages.scrollHeight,
        behavior: smooth ? 'smooth' : 'auto',
      });
      const escapeHtml = (value) => {
        const div = document.createElement('div');
        div.textContent = value;
        return div.innerHTML;
      };
      const appendMessage = (message) => {
        if (messages.querySelector(`[data-id="${message.id}"]`)) return;
        const mine = Number(message.user_id) === {{ auth()->id() }};
        messages.insertAdjacentHTML('beforeend', `
          <article class="${mine ? 'is-me' : 'is-other'}" data-id="${message.id}">
            ${mine ? '' : '<b>MTW</b>'}
            <div><p>${escapeHtml(message.body)}</p><time>${message.time}</time></div>
          </article>
        `);
        lastId = Math.max(lastId, Number(message.id));
        messages.dataset.lastId = lastId;
        welcome?.setAttribute('hidden', 'hidden');
        scrollToBottom();
      };

      form.addEventListener('submit', async (event) => {
        event.preventDefault();
        if (!textarea.value.trim()) return;
        const response = await fetch(form.action, {
          method: 'POST',
          headers: { 'X-CSRF-TOKEN': form.querySelector('[name="_token"]').value, 'Accept': 'application/json' },
          body: new FormData(form),
        });
        if (!response.ok) return;
        appendMessage(await response.json());
        textarea.value = '';
      });

      const poll = async () => {
        const response = await fetch(`{{ route('user.support-chat.messages') }}?after=${lastId}`, { headers: { 'Accept': 'application/json' } });
        if (!response.ok) return;
        const payload = await response.json();
        payload.messages.forEach(appendMessage);
      };

      requestAnimationFrame(() => scrollToBottom(false));
      window.addEventListener('load', () => scrollToBottom(false));
      window.setTimeout(() => scrollToBottom(false), 120);
      window.setInterval(poll, 3000);
      const dashboard = document.querySelector('.tcw-client-dashboard');
      document.querySelector('.tcw-client-sidebar-toggle')?.addEventListener('click', () => dashboard?.classList.toggle('is-sidebar-open'));
      document.querySelector('.tcw-client-sidebar-overlay')?.addEventListener('click', () => dashboard?.classList.remove('is-sidebar-open'));
      document.querySelector('.tcw-client-sidebar-close')?.addEventListener('click', () => dashboard?.classList.remove('is-sidebar-open'));
    })();
  </script>
@endpush

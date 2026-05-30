@extends('layouts.admin')

@section('title', 'Support Chats')
@section('body_class', 'admin-dashboard-theme admin-support-theme')
@section('header')
  <h2 class="admin-u-001">Support Chats</h2>
@endsection

@section('content')
  <section class="admin-support-layout">
    <article class="admin-support-list">
      <header>
        <div>
          <h3>Client Conversations</h3>
          <p>Direct chats started by clients from their dashboard.</p>
        </div>
        <b>Total: {{ $conversations->total() }}</b>
      </header>

      <div class="admin-support-table">
        <table>
          <thead>
            <tr>
              <th>Client</th>
              <th>Email</th>
              <th>Messages</th>
              <th>Last Message</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($conversations as $conversation)
              <tr class="{{ $activeConversation?->id === $conversation->id ? 'is-active' : '' }}">
                <td>
                  <span class="admin-support-client">
                    <b>{{ str($conversation->user->name)->substr(0, 1) }}</b>
                    {{ $conversation->user->name }}
                  </span>
                </td>
                <td>{{ $conversation->user->email }}</td>
                <td>{{ $conversation->messages_count }}</td>
                <td>{{ $conversation->last_message_at?->locale(app()->getLocale())->translatedFormat('d M, Y h:i A') ?: __('website.client.no_messages') }}</td>
                <td><a href="{{ route('support-chats.show', $conversation) }}">Open</a></td>
              </tr>
            @empty
              <tr><td colspan="5">No support chats yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </article>

    <article class="admin-support-thread">
      @if($activeConversation)
        <header>
          <div>
            <span>{{ str($activeConversation->user->name)->substr(0, 1) }}</span>
            <div>
              <h3>Chat with {{ $activeConversation->user->name }}</h3>
              <p>{{ $activeConversation->user->email }}</p>
            </div>
          </div>
          <b>Online</b>
        </header>

        <div class="admin-support-messages" id="admin-support-messages" data-last-id="{{ $activeConversation->messages->last()?->id ?? 0 }}">
          @if($activeConversation->messages->isNotEmpty())
            <em>{{ $activeConversation->messages->first()->created_at->locale(app()->getLocale())->translatedFormat('d M, Y') }}</em>
          @endif
          @foreach($activeConversation->messages as $message)
            <article class="{{ $message->user->isAdmin() ? 'is-admin' : 'is-client' }}" data-id="{{ $message->id }}">
              <strong>{{ $message->user->name }}</strong>
              <p>{{ $message->body }}</p>
              <time>{{ $message->created_at->locale(app()->getLocale())->translatedFormat('h:i A') }}</time>
            </article>
          @endforeach
        </div>

        <form id="admin-support-form" action="{{ route('support-chats.store', $activeConversation) }}" method="POST">
          @csrf
          <textarea name="body" placeholder="Write reply..." required></textarea>
          <button type="submit" aria-label="Send reply">Send</button>
        </form>
      @else
        <div class="admin-support-empty">No support chats yet.</div>
      @endif
    </article>
  </section>

  @if($activeConversation)
    <script>
      (() => {
        const messages = document.getElementById('admin-support-messages');
        const form = document.getElementById('admin-support-form');
        const textarea = form.querySelector('textarea');
        let lastId = Number(messages.dataset.lastId || 0);
        const escapeHtml = (value) => { const div = document.createElement('div'); div.textContent = value; return div.innerHTML; };
        const appendMessage = (message) => {
          if (messages.querySelector(`[data-id="${message.id}"]`)) return;
          messages.insertAdjacentHTML('beforeend', `
            <article class="${message.is_admin ? 'is-admin' : 'is-client'}" data-id="${message.id}">
              <strong>${escapeHtml(message.user_name)}</strong>
              <p>${escapeHtml(message.body)}</p>
              <time>${message.time}</time>
            </article>
          `);
          lastId = Math.max(lastId, Number(message.id));
          messages.scrollTop = messages.scrollHeight;
        };
        form.addEventListener('submit', async (event) => {
          event.preventDefault();
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
          const response = await fetch(`{{ route('support-chats.messages', $activeConversation) }}?after=${lastId}`, { headers: { 'Accept': 'application/json' } });
          if (!response.ok) return;
          (await response.json()).messages.forEach(appendMessage);
        };
        messages.scrollTop = messages.scrollHeight;
        window.setInterval(poll, 3000);
      })();
    </script>
  @endif
@endsection

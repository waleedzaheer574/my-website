@extends('layouts.admin')

@section('title', 'Support Chat')
@section('header')
  <h2 class="admin-u-001">Chat with {{ $conversation->user->name }}</h2>
@endsection

@section('content')
  <div class="card admin-support-chat">
    <div class="admin-support-messages" id="admin-support-messages" data-last-id="{{ $conversation->messages->last()?->id ?? 0 }}">
      @forelse($conversation->messages as $message)
        <article class="{{ $message->user->isAdmin() ? 'is-admin' : 'is-client' }}" data-id="{{ $message->id }}">
          <strong>{{ $message->user->name }}</strong>
          <p>{{ $message->body }}</p>
          <time>{{ $message->created_at->format('d M, h:i A') }}</time>
        </article>
      @empty
        <p>No messages yet.</p>
      @endforelse
    </div>
    <form id="admin-support-form" action="{{ route('support-chats.store', $conversation) }}" method="POST">
      @csrf
      <textarea name="body" placeholder="Write reply..." required></textarea>
      <button class="btn btn-primary" type="submit">Send Reply</button>
    </form>
  </div>
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
            <time>${message.date}, ${message.time}</time>
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
        const response = await fetch(`{{ route('support-chats.messages', $conversation) }}?after=${lastId}`, { headers: { 'Accept': 'application/json' } });
        if (!response.ok) return;
        (await response.json()).messages.forEach(appendMessage);
      };
      messages.scrollTop = messages.scrollHeight;
      window.setInterval(poll, 3000);
    })();
  </script>
@endsection

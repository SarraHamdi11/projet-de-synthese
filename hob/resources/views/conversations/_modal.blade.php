<div class="chat-header">
    @if($otherUser)
        <img src="{{ $otherUser->photodeprofil_uti ? asset('storage/' . $otherUser->photodeprofil_uti) : asset('images/default-avatar.png') }}" alt="{{ $otherUser->prenom }}">
        <span>{{ $otherUser->prenom }} {{ $otherUser->nom_uti }}</span>
    @else
        <span>Utilisateur inconnu</span>
    @endif
    <button class="close-chat-btn" title="Fermer">&times;</button>
</div>
<div class="chat-messages">
    @foreach($messages as $message)
        <div class="chat-message {{ $message->sender_id === Auth::id() ? 'sent' : 'received' }}">
            {{ $message->message }}
            <div class="message-time">{{ $message->created_at->format('H:i') }}</div>
        </div>
    @endforeach
</div>
<div class="chat-footer">
    <form id="message-form-modal" autocomplete="off" style="width:100%;">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $otherUser->id ?? '' }}">
        <div class="input-group">
            <input type="text" name="message" class="form-control" placeholder="Écrivez votre message..." required>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </form>
</div>
<script>
// You can add modal-specific JS here if needed
</script>
<style>
    .chat-messages {
        display: flex;
        flex-direction: column;
        gap: 0;
    }
    .chat-message {
        max-width: 200px;
        padding: 8px 10px;
        margin-bottom: 7px;
        border-radius: 15px;
        font-size: 14px;
        word-break: break-word;
        display: inline-block;
    }
    .chat-message.sent {
        background: #24507a;
        color: #fff;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
        text-align: right;
    }
    .chat-message.received {
        background: #e9ecef;
        color: #222;
        align-self: flex-start;
        border-bottom-left-radius: 4px;
        text-align: left;
    }
</style> 
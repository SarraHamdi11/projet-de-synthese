<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Message;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;

    /**
     *
     * @param  Message  $message
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     *
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     *
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $sender = $this->message->sender;
        $messageType = $this->message->message_type;
        $content = $messageType === 'text' ? $this->message->message : 
                  ($messageType === 'image' ? 'une image' : 'un fichier');

        return (new MailMessage)
            ->subject('Nouveau message de ' . $sender->prenom)
            ->greeting('Bonjour ' . $notifiable->prenom . '!')
            ->line($sender->prenom . ' vous a envoyé un nouveau message.')
            ->line('Message: ' . $content)
            ->action('Voir le message', route('messages.show', $sender->id))
            ->line('Merci d\'utiliser notre application!');
    }

    /**
     *
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message_id' => $this->message->id,
            'sender_id' => $this->message->sender_id,
            'sender_name' => $this->message->sender->prenom . ' ' . $this->message->sender->nom_uti,
            'message_type' => $this->message->message_type,
            'message' => $this->message->message_type === 'text' ? $this->message->message : 
                        ($this->message->message_type === 'image' ? 'une image' : 'un fichier'),
            'created_at' => $this->message->created_at
        ];
    }
} 
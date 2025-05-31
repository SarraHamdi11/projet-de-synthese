<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservation;

class ReservationCreatedNotification extends Notification
{
    use Queueable;

    public $reservation;

    /**
     * Create a new notification instance.
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        $locataire = \App\Models\Utilisateur::find($this->reservation->locataire_id);
        return [
            'message' => 'Vous avez une nouvelle réservation',
            'reservation_id' => $this->reservation->id,
            'locataire_id' => $this->reservation->locataire_id,
            'name' => $locataire ? ($locataire->prenom . ' ' . $locataire->nom_uti) : 'Utilisateur',
            'avatar' => $locataire && $locataire->photodeprofil_uti ? asset('storage/' . $locataire->photodeprofil_uti) : asset('images/default-avatar.png'),
            'type' => 'reservation',
        ];
    }
}

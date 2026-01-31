<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewAnnonceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $annonceTitle;

    /**
     *
     * @param  string  $annonceTitle
     * @return void
     */
    public function __construct(string $annonceTitle)
    {
        $this->annonceTitle = $annonceTitle;
    }

    /**
     *
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     *
     *
     * @param  mixed  $notifiable
     * @return DatabaseMessage
     */
    public function toDatabase(object $notifiable): DatabaseMessage
    {
        return new DatabaseMessage([
            'title' => 'Nouvelle annonce créée',
            'body' => "Vous avez créé une nouvelle annonce : {$this->annonceTitle}.",
            'link' => '#', // TODO: Replace with the actual link to the annonce
            'user_name' => $notifiable->prenom . ' ' . $notifiable->nom_uti,
            'user_role' => $notifiable->role_uti,
            //'user_avatar' => $notifiable->photodeprofil_uti // Uncomment if you have user avatars
        ]);
    }

    /**
     *
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
} 
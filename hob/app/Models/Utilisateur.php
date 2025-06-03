<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class Utilisateur extends Authenticatable
{
    use HasFactory; 
    use Notifiable;
    protected $table = 'utilisateurs';
    protected $fillable = [
        'nom_uti', 'prenom', 'email_uti', 'mot_de_passe_uti', 'role_uti',
        'photodeprofil_uti', 'tel_uti', 'date_inscription_uti', 'ville', 'date_naissance'
    ];
    protected $hidden = [
        'mot_de_passe_uti', 'remember_token'
    ];
        protected $primaryKey = 'id';
        

    public function getAuthPassword()
    {
        return $this->mot_de_passe_uti;
    }
    // Propriétés à caster en types spécifiques
    protected $casts = [
        'date_naissance' => 'datetime', // Exemple de conversion en type date
        'date_inscription_uti' => 'datetime',
        'mot_de_passe_uti' => 'encrypted', // Exemple de champ à crypter
    ]; 

    public function conversationsAsExpediteur()
    {
        return $this->hasMany(Conversation::class, 'expediteur_id');
    }

    public function conversationsAsDestinataire()
    {
        return $this->hasMany(Conversation::class, 'destinataire_id');
    }

    public function getAllConversationsAttribute()
    {
        return Conversation::where('expediteur_id', $this->id)
            ->orWhere('destinataire_id', $this->id)
            ->get();
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Get all messages received by this user (as receiver).
     * Usage: $user->receivedMessages()
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function expeditions()
    {
        return $this->hasMany(Conversation::class, 'expediteur_id');
    }

    public function receptions()
    {
        return $this->hasMany(Conversation::class, 'destinataire_id');
    }
    public function reservations_pro()
    {
        return $this->hasMany(Reservation::class, 'proprietaire_id');
    }
    public function reservations_loca()
    {
        return $this->hasMany(Reservation::class, 'locataire_id');
    }
    
    public function Annonce()
    {
        return $this->hasMany(Annonce::class);
    }
    public function Avis (){
        return $this->hasMany(Avis::class);
    }
    public function Favori (){
        return $this->hasMany(Favori::class);
    }


    public function getEmailForPasswordReset()
    {
        return $this->email_uti;
    }

   

    // Optionally, disable remember token if not needed
    public function setRememberToken($value)
    {
        // Do nothing to prevent updating a non-existent column
    }

    public function getRememberToken()
    {
        return null; // Or return a custom column if you add one later
    }
    public function getRememberTokenName()
    {
        return ''; // Disable remember token column
    }

     public function annonces()
    {
        return $this->hasMany(Annonce::class, 'proprietaire_id', 'id');
    }

    // Relationship with Avis through Annonce
   


    // Remove the incorrect notifications relationship since we're using the Notifiable trait
    // public function notifications()
    // {
    //     return $this->hasMany(Notification::class);
    // }

   

   

    // Optionally, disable remember token if not needed
    
   

   
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory ;

    protected $table = 'notifications'; // Specify the table name

    protected $fillable = [
        'type', 'data', 'read_at', 'notifiable_type', 'notifiable_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    // The morphTo relationship is already handled by the notifiable_type and notifiable_id columns
    // public function notifiable()
    // {
    //     return $this->morphTo();
    // }
}

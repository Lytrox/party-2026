<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserOption extends Model
{

    protected $fillable = [
        'user_id',
        'attending',
        'allergies',
        'allergies_description',
        'providing_stuff',
        'drinking_alcohol',
        'bringing_fursuit',
        'comments',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}

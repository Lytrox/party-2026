<?php

namespace App\Models;

use Database\Factories\RsvpFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rsvp extends Model
{
    /** @use HasFactory<RsvpFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'user_id',
        'badge_name',
        'attending',
        'has_allergies',
        'allergies',
        'bringing',
        'bringing_music_equipment',
        'drinking_alcohol',
        'bringing_fursuit',
        'is_vegetarian',
        'is_vegan',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'attending' => 'boolean',
            'has_allergies' => 'boolean',
            'bringing_music_equipment' => 'boolean',
            'drinking_alcohol' => 'boolean',
            'bringing_fursuit' => 'boolean',
            'is_vegetarian' => 'boolean',
            'is_vegan' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

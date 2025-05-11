<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'country',
        'date',
        'time',
        'capacity',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
        'capacity' => 'integer',
    ];

    /**
     * Get the bookings for the event.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the number of available spots for the event.
     */
    public function getAvailableSpotsAttribute(): int
    {
        return $this->capacity - $this->bookings()->count();
    }

    /**
     * Check if the event is fully booked.
     */
    public function isFullyBooked(): bool
    {
        return $this->bookings()->count() >= $this->capacity;
    }
}
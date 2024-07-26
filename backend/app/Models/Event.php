<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\EventCreated;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'reserve_at',
        'type',
        'event_date',
        'guests',
        'cost',
        'status',
        'saldo'
    ];
    public function areas()
    {
        return $this->belongsToMany(Area::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pays()
    {
        return $this->hasMany(Pay::class);
    }
    protected $dispatchesEvents = [
        'created' => EventCreated::class,
    ];
}

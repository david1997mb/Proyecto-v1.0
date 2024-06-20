<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'reserve_date',
        'type',
        'event_day',
        'start',
        'finish',
        'guests',
        'total_cost',
        'status',
        'client_id'
        ];
    public function client(): BelongsTo{
        return $this->belongsTo(Client::class);
    }
    public function pays(): HasMany{
        return $this->hasMany(Pay::class);
    }
}

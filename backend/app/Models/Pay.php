<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pay extends Model
{
    use HasFactory;
    protected $fillable = [
        'pay_date',
        'amount',
        'pay_type',
        'pay_status',
        'deuda',
        'event_id'
        ];
    public function event(): BelongsTo{
        return $this->belongsTo(Event::class);
    }
}

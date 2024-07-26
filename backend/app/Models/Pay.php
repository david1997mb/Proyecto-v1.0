<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'amount',
        'pay_date',
        'method'
    ];
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}

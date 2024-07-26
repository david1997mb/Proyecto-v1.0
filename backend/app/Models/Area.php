<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Area extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
    ];
    public function events() {
        return $this->belongsToMany(Event::class);
    }
}

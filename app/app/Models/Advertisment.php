<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Advertisment extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'price'];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
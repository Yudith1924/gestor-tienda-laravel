<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Events\RealtimeUpdateEvent;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_url',
        'price',
        'stock',
        'status',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    protected static function booted()
    {
        static::created(function () {
            broadcast(new RealtimeUpdateEvent());
        });

        static::updated(function () {
            broadcast(new RealtimeUpdateEvent());
        });

        static::deleted(function () {
            broadcast(new RealtimeUpdateEvent());
        });
    }
}
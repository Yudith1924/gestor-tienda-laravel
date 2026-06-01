<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Events\RealtimeUpdateEvent;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
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
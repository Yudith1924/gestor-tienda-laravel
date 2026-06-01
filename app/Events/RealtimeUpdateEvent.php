<?php

namespace App\Events;

use App\Models\Order;
use App\Models\Product;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;

use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RealtimeUpdateEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $dashboardData;

    public function __construct()
    {
        $this->dashboardData = [

            'total_products' => Product::count(),

            'total_orders' => Order::count(),

            'total_stock' => Product::sum('stock') ?? 0,

            'products' => Product::select('name', 'stock')
                ->latest()
                ->take(5)
                ->get()
                ->toArray(),

            'top_sales' => Product::select('name', 'stock as total_sales')
                ->orderBy('stock', 'asc')
                ->take(5)
                ->get()
                ->toArray()
        ];
    }

    public function broadcastOn(): Channel
    {
        return new Channel('shop-channel');
    }

    public function broadcastAs(): string
    {
        return 'dashboard.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'dashboardData' => $this->dashboardData
        ];
    }
}
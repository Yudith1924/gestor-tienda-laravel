<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\ManageProducts;
use App\Livewire\CustomerDashboard;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

// Endpoint en tiempo real para alimentar el Dashboard estilo Donezo sin hacer refresh
Route::get('/api/dashboard-realtime', function () {
    // Calculamos el Top 5 de productos más vendidos contando cuántas órdenes tiene cada product_id
    $topSales = Order::select('product_id', DB::raw('count(*) as total_sales'))
        ->groupBy('product_id')
        ->orderBy('total_sales', 'desc')
        ->take(5)
        ->get()
        ->map(function($order) {
            return [
                // Usamos la relación 'product' que definimos en el modelo para traer el nombre
                'name' => $order->product ? $order->product->name : 'Producto Eliminado',
                'total_sales' => $order->total_sales
            ];
        });

    return response()->json([
        'total_products' => Product::count(),
        'total_orders'   => Order::count(),
        'total_stock'    => Product::sum('stock'),
        'products'       => Product::select('name', 'stock')->get(),
        'top_sales'      => $topSales
    ]);
});

// Ruta de inicio pública (la landing page limpia que creamos)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Vista del Dashboard principal (donde pegaste el diseño de Donezo con las gráficas)
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rutas de tus componentes de Livewire tradicionales
Route::get('/admin/productos', ManageProducts::class)->middleware(['auth']);
Route::get('/tienda', CustomerDashboard::class);

// Grupo de rutas protegidas de la configuración de usuario (Volt)
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
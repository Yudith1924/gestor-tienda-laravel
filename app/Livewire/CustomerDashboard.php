<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Events\RealtimeUpdateEvent;

class CustomerDashboard extends Component
{
    public $successMessage;
    public $errorMessage; // <-- Declaramos una propiedad para los errores

    /**
     * Procesa la compra de un producto
     */
    public function buyProduct($productId)
    {
        // Limpiamos mensajes anteriores antes de procesar una nueva compra
        $this->successMessage = null;
        $this->errorMessage = null;

        $product = Product::find($productId);

        // Validamos que haya stock suficiente
        if (!$product || $product->stock <= 0) {
            // <-- CORREGIDO: Usamos la propiedad pública en vez de session()
            $this->errorMessage = 'Lo sentimos, este producto ya no tiene stock disponible.';
            return;
        }

        // 1. Restamos 1 al stock del producto y lo guardamos
        $product->decrement('stock');

        // 2. Registramos la orden de compra
        Order::create([
            'user_id' => Auth::id() ?? 1, 
            'product_id' => $product->id,
            'quantity' => 1,
            'total' => $product->price,
        ]);

        // 3. ¡EL CHISPAZO MÁGICO PARA LA TIENDA! 
        event(new RealtimeUpdateEvent());

        $this->successMessage = '¡Felicidades! Tu compra de "' . $product->name . '" se procesó con éxito.';
    }

    public function render()
    {
        return view('livewire.customer-dashboard', [
            'products' => Product::where('stock', '>', 0)->latest()->get()
        ]);
    }
}
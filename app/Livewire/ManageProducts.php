<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Events\RealtimeUpdateEvent;

class ManageProducts extends Component
{
    public $name;
    public $description;
    public $image_url;
    public $price;
    public $stock;

    public $successMessage;

    public $editingId = null;

    protected $rules = [
        'name' => 'required|string|min:3|max:100',
        'description' => 'required|string|min:5|max:500',
        'image_url' => 'nullable|url',
        'price' => 'required|numeric|min:1',
        'stock' => 'required|integer|min:0',
    ];

    // =========================================
    // EDITAR PRODUCTO
    // =========================================

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);

        $this->editingId = $product->id;

        $this->name = $product->name;
        $this->description = $product->description;
        $this->image_url = $product->image_url;
        $this->price = $product->price;
        $this->stock = $product->stock;
    }

    // =========================================
    // GUARDAR / ACTUALIZAR
    // =========================================

    public function saveProduct()
    {
        $this->validate();

        // ===============================
        // EDITAR
        // ===============================

        if ($this->editingId) {

            $product = Product::findOrFail($this->editingId);

            $product->update([
                'name' => trim($this->name),
                'description' => trim($this->description),
                'image_url' => $this->image_url
                    ? trim($this->image_url)
                    : null,

                'price' => $this->price,
                'stock' => $this->stock,

                'status' => $this->stock > 0
                    ? 'active'
                    : 'inactive',
            ]);

            $this->successMessage =
                'Producto actualizado correctamente.';

        }

        // ===============================
        // CREAR
        // ===============================

        else {

            Product::create([
                'name' => trim($this->name),
                'description' => trim($this->description),
                'image_url' => $this->image_url
                    ? trim($this->image_url)
                    : null,

                'price' => $this->price,
                'stock' => $this->stock,

                'status' => $this->stock > 0
                    ? 'active'
                    : 'inactive',
            ]);

            $this->successMessage =
                'Producto creado correctamente.';
        }

        // EVENTO REALTIME
        event(new RealtimeUpdateEvent());

        // RESET
        $this->reset([
            'name',
            'description',
            'image_url',
            'price',
            'stock',
            'editingId'
        ]);
    }

    // =========================================
    // RENDER
    // =========================================

    public function render()
    {
        return view('livewire.manage-products', [
            'products' => Product::latest()->get()
        ]);
    }
}
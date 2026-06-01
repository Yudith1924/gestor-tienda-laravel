<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');         
            $table->text('description');   
            $table->string('image_url')->nullable(); // <-- Agregamos esta línea de forma segura aquí
            $table->decimal('price', 10, 2); 
            $table->integer('stock');       
            $table->string('status')->default('active'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    } 
};
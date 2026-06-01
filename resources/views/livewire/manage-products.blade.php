<div style="width: 100%; display: flex; flex-direction: column; gap: 32px; font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif; background-color: #f4f7f6; min-height: 100vh; padding: 32px; box-sizing: border-box; color: #1e293b;">

    <script>
        document.title = "Administrar Productos";
    </script>

    <!-- HEADER -->
    <div style="background-color: #064e3b; padding: 28px; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(6, 78, 59, 0.1);">
        <h1 style="margin: 0; font-size: 1.8rem; color: #ffffff; font-weight: 700;">
            Panel de Ventas
        </h1>

        <p style="margin: 6px 0 0 0; color: #a7f3d0; font-size: 0.95rem;">
            Administra tus publicaciones e inventario en tiempo real.
        </p>
    </div>

    <div style="display: flex; flex-wrap: wrap; gap: 24px;">

        <!-- FORMULARIO -->
        <div style="flex: 1 1 350px; background-color: #ffffff; border: 1px solid #e2e8f0; padding: 28px; border-radius: 16px; box-sizing: border-box;">

            <h3 style="margin-top:0; margin-bottom:20px; color:#0f172a; font-size:1.2rem; font-weight:700;">

                @if($editingId)
                    Editar producto
                @else
                    Publicar un artículo
                @endif

            </h3>

            @if ($successMessage)
                <div style="margin-bottom: 20px; padding: 14px; background-color: #e6f4ea; border-left: 5px solid #10b981; color: #137333; border-radius: 4px 10px 10px 4px; font-weight: 600;">
                    ✓ {{ $successMessage }}
                </div>
            @endif

            <form wire:submit.prevent="saveProduct"
                  style="display:flex; flex-direction:column; gap:18px;">

                <!-- NOMBRE -->
                <div>

                    <label style="display:block; font-size:0.85rem; font-weight:600; color:#475569; margin-bottom:6px;">
                        Nombre del producto
                    </label>

                    <input
                        type="text"
                        wire:model="name"
                        placeholder="Ej. Coca Cola 600ml"
                        style="width:100%; border-radius:10px; border:1px solid #cbd5e1; padding:12px; background:#f8fafc;"
                    >

                    @error('name')
                        <span style="color:#ef4444; font-size:0.75rem;">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <!-- DESCRIPCIÓN -->
                <div>

                    <label style="display:block; font-size:0.85rem; font-weight:600; color:#475569; margin-bottom:6px;">
                        Descripción
                    </label>

                    <textarea
                        wire:model="description"
                        rows="3"
                        placeholder="Describe el producto..."
                        style="width:100%; border-radius:10px; border:1px solid #cbd5e1; padding:12px; resize:vertical; background:#f8fafc;"
                    ></textarea>

                    @error('description')
                        <span style="color:#ef4444; font-size:0.75rem;">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <!-- IMAGEN -->
                <div>

                    <label style="display:block; font-size:0.85rem; font-weight:600; color:#475569; margin-bottom:6px;">
                        URL de imagen
                    </label>

                    <input
                        type="url"
                        wire:model="image_url"
                        placeholder="https://..."
                        style="width:100%; border-radius:10px; border:1px solid #cbd5e1; padding:12px; background:#f8fafc;"
                    >

                    @error('image_url')
                        <span style="color:#ef4444; font-size:0.75rem;">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <!-- PRECIO Y STOCK -->
                <div style="display:flex; gap:14px;">

                    <div style="flex:1;">

                        <label style="display:block; font-size:0.85rem; font-weight:600; color:#475569; margin-bottom:6px;">
                            Precio
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            wire:model="price"
                            placeholder="0.00"
                            style="width:100%; border-radius:10px; border:1px solid #cbd5e1; padding:12px; background:#f8fafc;"
                        >

                        @error('price')
                            <span style="color:#ef4444; font-size:0.75rem;">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                    <div style="flex:1;">

                        <label style="display:block; font-size:0.85rem; font-weight:600; color:#475569; margin-bottom:6px;">
                            Stock
                        </label>

                        <input
                            type="number"
                            wire:model="stock"
                            placeholder="Cantidad"
                            style="width:100%; border-radius:10px; border:1px solid #cbd5e1; padding:12px; background:#f8fafc;"
                        >

                        @error('stock')
                            <span style="color:#ef4444; font-size:0.75rem;">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                </div>

                <!-- BOTÓN -->
                <button
                    type="submit"
                    style="width:100%; background-color:#10b981; color:#fff; font-weight:600; padding:12px; border-radius:10px; border:none; cursor:pointer; margin-top:6px;"
                >

                    @if($editingId)
                        Guardar cambios
                    @else
                        Publicar producto
                    @endif

                </button>

            </form>

        </div>

        <!-- LISTA PRODUCTOS -->
        <div style="flex: 1 1 500px; background-color:#ffffff; border:1px solid #e2e8f0; padding:28px; border-radius:16px;">

            <h3 style="margin-top:0; margin-bottom:20px; color:#0f172a; font-size:1.2rem; font-weight:700;">
                Todos los productos
            </h3>

            @if($products->isEmpty())

                <div style="padding:40px; text-align:center; color:#64748b; border:2px dashed #cbd5e1; border-radius:12px;">
                    No hay productos registrados.
                </div>

            @else

                <div style="display:flex; flex-direction:column; gap:14px;">

                    @foreach($products as $product)

                        <div style="
                            display:flex;
                            justify-content:space-between;
                            align-items:center;
                            border:1px solid #e2e8f0;
                            padding:16px;
                            border-radius:12px;
                            background-color:#f8fafc;
                            gap:16px;
                            opacity: {{ $product->status === 'inactive' ? '0.7' : '1' }};
                        ">

                            <!-- INFO -->
                            <div style="display:flex; align-items:center; gap:16px; flex:1;">

                                <div style="
                                    width:60px;
                                    height:60px;
                                    border-radius:8px;
                                    overflow:hidden;
                                    background-color:#e2e8f0;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    flex-shrink:0;
                                ">

                                    @if(!empty(trim($product->image_url)))

                                        <img
                                            src="{{ $product->image_url }}"
                                            alt="{{ $product->name }}"
                                            style="width:100%; height:100%; object-fit:cover;"
                                        >

                                    @else

                                        <span style="font-size:1.5rem;">📦</span>

                                    @endif

                                </div>

                                <div>

                                    <h4 style="margin:0; font-size:1.05rem; color:#1e293b; font-weight:600;">
                                        {{ $product->name }}
                                    </h4>

                                    <p style="margin:4px 0; font-size:0.85rem; color:#64748b; line-height:1.4;">
                                        {{ Str::limit($product->description, 60) }}
                                    </p>

                                    <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">

                                        <span style="
                                            font-size:0.75rem;
                                            background-color:#e6f4ea;
                                            color:#137333;
                                            padding:2px 6px;
                                            border-radius:6px;
                                            font-weight:700;
                                        ">
                                            Stock: {{ $product->stock }}
                                        </span>

                                        @if($product->stock > 0)

                                            <span style="
                                                font-size:0.75rem;
                                                background:#dcfce7;
                                                color:#166534;
                                                padding:2px 6px;
                                                border-radius:6px;
                                                font-weight:700;
                                            ">
                                                Disponible
                                            </span>

                                        @else

                                            <span style="
                                                font-size:0.75rem;
                                                background:#fee2e2;
                                                color:#991b1b;
                                                padding:2px 6px;
                                                border-radius:6px;
                                                font-weight:700;
                                            ">
                                                Agotado
                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </div>

                            <!-- PRECIO Y ACCIONES -->
                            <div style="display:flex; flex-direction:column; gap:10px; align-items:flex-end;">

                                <span style="font-size:1.2rem; font-weight:700; color:#0f172a;">
                                    ${{ number_format($product->price, 2) }}
                                </span>

                                <button
                                    wire:click="editProduct({{ $product->id }})"
                                    style="
                                        background:#064e3b;
                                        color:white;
                                        border:none;
                                        padding:10px 16px;
                                        border-radius:10px;
                                        cursor:pointer;
                                        font-weight:600;
                                    "
                                >
                                    Editar
                                </button>

                            </div>

                        </div>

                    @endforeach

                </div>

            @endif

        </div>

    </div>

</div>
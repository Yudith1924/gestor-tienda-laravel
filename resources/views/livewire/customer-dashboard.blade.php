<div
    id="shop-component"
    style="width: 100%; font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif; background-color: #f4f7f6; min-height: 100vh; padding: 32px; box-sizing: border-box; color: #1e293b;"
>

    <script>
        document.title = "Tienda";
    </script>

    <!-- HEADER -->
    <div style="background-color: #064e3b; padding: 28px; border-radius: 16px; margin-bottom: 32px; box-shadow: 0 4px 6px -1px rgba(6, 78, 59, 0.1); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">

        <div>
            <h1 style="margin: 0; font-size: 1.8rem; color: #ffffff; font-weight: 700; letter-spacing: -0.5px;">
                ¡Bienvenido!
            </h1>

            <p style="margin: 6px 0 0 0; color: #a7f3d0; font-size: 0.95rem;">
                Encuentra los mejores productos a los mejores precios.
            </p>
        </div>

        <a
            href="/admin/productos"
            style="background-color: #ffffff; color: #064e3b; text-decoration: none; padding: 12px 20px; border-radius: 10px; font-weight: 600; font-size: 0.9rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05);"
        >
            Ir a modo Vendedor
        </a>

    </div>

    <!-- ALERTAS -->
    @if ($successMessage)

        <div style="margin-bottom: 24px; padding: 16px; background-color: #e6f4ea; border-left: 5px solid #10b981; color: #137333; border-radius: 8px; font-weight: 600; font-size: 0.95rem;">
            ✓ {{ $successMessage }}
        </div>

    @endif

    @if ($errorMessage)

        <div style="margin-bottom: 24px; padding: 16px; background-color: #fee2e2; border-left: 5px solid #ef4444; color: #991b1b; border-radius: 8px; font-weight: 600; font-size: 0.95rem;">
            ⚠️ {{ $errorMessage }}
        </div>

    @endif

    <!-- TITULO -->
    <h2 style="color: #0f172a; font-size: 1.4rem; margin-bottom: 24px; font-weight: 700;">
        Productos destacados
    </h2>

    <!-- PRODUCTOS -->
    @if($products->isEmpty())

        <div style="background-color: #ffffff; padding: 48px; text-align: center; color: #64748b; border-radius: 16px; border: 1px solid #e2e8f0;">

            <p style="margin: 0; font-size: 1.1rem; font-weight: 600; color: #0f172a;">
                Por el momento no hay productos disponibles.
            </p>

            <p style="margin: 6px 0 0 0; font-size: 0.9rem;">
                Ve al Panel de Vendedor para publicar el primero.
            </p>

        </div>

    @else

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 24px;">

            @foreach($products as $product)

                <div style="background-color: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">

                    <!-- IMAGEN -->
                    <div style="width: 100%; height: 200px; background-color: #f8fafc; display: flex; align-items: center; justify-content: center; overflow: hidden;">

                        @if(!empty(trim($product->image_url)))

                            <img
                                src="{{ $product->image_url }}"
                                alt="{{ $product->name }}"
                                style="width: 100%; height: 100%; object-fit: cover;"
                            >

                        @else

                            <span style="font-size: 3rem;">
                                📦
                            </span>

                        @endif

                    </div>

                    <!-- CONTENIDO -->
                    <div style="padding: 20px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; gap: 16px;">

                        <div>

                            <span style="font-size: 1.5rem; font-weight: 700; color: #0f172a; display: block; margin-bottom: 6px;">
                                ${{ number_format($product->price, 2) }}
                            </span>

                            <h3 style="margin: 0 0 6px 0; font-size: 1.05rem; color: #1e293b; font-weight: 600;">
                                {{ $product->name }}
                            </h3>

                            <p style="margin: 0; font-size: 0.85rem; color: #64748b; line-height: 1.5;">
                                {{ Str::limit($product->description, 75) }}
                            </p>

                        </div>

                        <div>

                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">

                                <span style="font-size: 0.75rem; color: #064e3b; font-weight: 700; background-color: #e6f4ea; padding: 4px 8px; border-radius: 6px;">
                                    Envío gratis
                                </span>

                                <span style="font-size: 0.8rem; color: #64748b;">

                                    Disponibles:

                                    @if($product->stock > 0)

                                        <b style="color: #10b981;">
                                            {{ $product->stock }}
                                        </b>

                                    @else

                                        <b style="color: #ef4444;">
                                            Agotado
                                        </b>

                                    @endif

                                </span>

                            </div>

                            @if($product->stock > 0)

                                <button
                                    wire:click="buyProduct({{ $product->id }})"
                                    style="width: 100%; background-color: #10b981; color: #ffffff; font-weight: 600; padding: 12px; border-radius: 10px; border: none; font-size: 0.9rem; cursor: pointer;"
                                >
                                    Comprar ahora
                                </button>

                            @else

                                <button
                                    disabled
                                    style="width: 100%; background-color: #cbd5e1; color: #64748b; font-weight: 600; padding: 12px; border-radius: 10px; border: none; font-size: 0.9rem; cursor: not-allowed;"
                                >
                                    Producto agotado
                                </button>

                            @endif

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

<!-- REALTIME WEBSOCKET -->
<!-- REALTIME WEBSOCKET -->
<script>
document.addEventListener('livewire:init', () => {

    console.log('🟢 Tienda conectada a Reverb');

    if (!window.Echo) {

        console.error('❌ Echo NO está cargado');
        return;
    }

    window.Echo.channel('shop-channel')

        .listen('.dashboard.updated', (event) => {

            console.log('⚡ Evento realtime recibido', event);

            // REFRESCA COMPLETAMENTE EL COMPONENTE LIVEWIRE
            Livewire.find(
                document.getElementById('shop-component')
                    .closest('[wire\\:id]')
                    .getAttribute('wire:id')
            ).$refresh();

        });

});
</script>
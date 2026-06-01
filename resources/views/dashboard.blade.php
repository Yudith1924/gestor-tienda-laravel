<script>
    document.title = "Dashboard";
</script>

<div style="background-color: #f4f7f6; font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif; min-height: 100vh; padding: 32px; color: #1e293b;">
    <div class="max-w-7xl mx-auto" style="display: flex; flex-direction: column; gap: 32px;">

        <!-- HEADER -->
        <div style="display: flex; justify-content: space-between; align-items: center;">

            <div>
                <h1 style="font-size: 2rem; font-weight: 700; margin: 0; color: #0f172a;">
                    Dashboard
                </h1>

                <p style="margin-top: 6px; color: #64748b;">
                    Monitorea tu inventario y ventas en tiempo real.
                </p>
            </div>

            <div style="display:flex; gap:12px;">

                <a href="/tienda"
                   style="text-decoration:none; background:#fff; color:#0f172a; padding:10px 18px; border-radius:10px; border:1px solid #e2e8f0;">
                    Ir a Tienda
                </a>

                <a href="/admin/productos"
                   style="text-decoration:none; background:#064e3b; color:#fff; padding:10px 18px; border-radius:10px;">
                    + Gestionar Productos
                </a>

            </div>

        </div>

        <!-- MÉTRICAS -->
        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:24px;">

            <!-- Productos -->
            <div style="background:#fff; padding:24px; border-radius:16px;">

                <div style="font-size:1.5rem;">📦</div>

                <span id="metric-products"
                      style="display:block; font-size:2.2rem; font-weight:700; margin-top:10px;">
                    {{ \App\Models\Product::count() }}
                </span>

                <span style="color:#64748b;">
                    Total Productos
                </span>

            </div>

            <!-- Ordenes -->
            <div style="background:#064e3b; padding:24px; border-radius:16px; color:white;">

                <div style="font-size:1.5rem;">📈</div>

                <span id="metric-orders"
                      style="display:block; font-size:2.2rem; font-weight:700; margin-top:10px;">
                    {{ \App\Models\Order::count() }}
                </span>

                <span style="color:#a7f3d0;">
                    Órdenes Concluidas
                </span>

            </div>

            <!-- Stock -->
            <div style="background:#fff; padding:24px; border-radius:16px;">

                <div style="font-size:1.5rem;">📊</div>

                <span id="metric-stock"
                      style="display:block; font-size:2.2rem; font-weight:700; margin-top:10px;">
                    {{ \App\Models\Product::sum('stock') }}
                </span>

                <span style="color:#64748b;">
                    Stock en Almacén
                </span>

            </div>

        </div>

        <!-- CHARTS -->
        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(450px,1fr)); gap:24px;">

            <!-- STOCK -->
            <div style="background:#fff; padding:24px; border-radius:18px;">

                <h3>Inventario (Stock)</h3>

                <div style="height:280px;">
                    <canvas id="stockChart"></canvas>
                </div>

            </div>

            <!-- SALES -->
            <div style="background:#fff; padding:24px; border-radius:18px;">

                <h3>Top Productos Más Vendidos</h3>

                <div style="height:280px;">
                    <canvas id="salesChart"></canvas>
                </div>

            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // =====================================================
    // CHART STOCK
    // =====================================================

    const stockChart = new Chart(
        document.getElementById('stockChart'),
        {
            type: 'bar',

            data: {
                labels: [],
                datasets: [{
                    label: 'Stock',
                    data: [],
                    backgroundColor: '#10b981',
                    borderRadius: 8,
                    barThickness: 24
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        }
    );

    // =====================================================
    // CHART SALES
    // =====================================================

    const salesChart = new Chart(
        document.getElementById('salesChart'),
        {
            type: 'doughnut',

            data: {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: [
                        '#064e3b',
                        '#10b981',
                        '#34d399',
                        '#6ee7b7',
                        '#a7f3d0'
                    ]
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        }
    );

    // =====================================================
    // FUNCIÓN RENDER
    // =====================================================

    function renderizarDashboard(data)
    {
        if (!data) return;

        document.getElementById('metric-products').innerText =
            data.total_products;

        document.getElementById('metric-orders').innerText =
            data.total_orders;

        document.getElementById('metric-stock').innerText =
            data.total_stock;

        // STOCK CHART
        stockChart.data.labels =
            data.products.map(p => p.name);

        stockChart.data.datasets[0].data =
            data.products.map(p => p.stock);

        stockChart.update();

        // SALES CHART
        salesChart.data.labels =
            data.top_sales.map(p => p.name);

        salesChart.data.datasets[0].data =
            data.top_sales.map(p => p.total_sales);

        salesChart.update();

        console.log('📊 Dashboard actualizado');
    }

    // =====================================================
    // DATOS INICIALES
    // =====================================================

    @php

        $dashboardData = [

            'total_products' =>
                \App\Models\Product::count(),

            'total_orders' =>
                \App\Models\Order::count(),

            'total_stock' =>
                \App\Models\Product::sum('stock') ?? 0,

            'products' =>
                \App\Models\Product::select('name', 'stock')
                    ->latest()
                    ->take(5)
                    ->get()
                    ->toArray(),

            'top_sales' =>
                \App\Models\Product::select('name', 'stock as total_sales')
                    ->orderBy('stock', 'asc')
                    ->take(5)
                    ->get()
                    ->toArray(),
        ];

    @endphp

    renderizarDashboard(@json($dashboardData));

    // =====================================================
    // PUSHER / REVERB
    // =====================================================

    Pusher.logToConsole = true;

    const pusher = new Pusher(
        '{{ env('REVERB_APP_KEY') }}',
        {
            cluster: 'mt1',
            
            wsHost: '127.0.0.1',
            wsPort: 8080,

            forceTLS: false,

            disableStats: true,

            enabledTransports: ['ws']
        }
    );

    console.log('✅ Pusher conectado');

    const channel = pusher.subscribe('shop-channel');

    channel.bind('dashboard.updated', function(data) {

        console.log('🔥 EVENTO RECIBIDO');

        console.log(data);

        if (data.dashboardData)
        {
            renderizarDashboard(
                data.dashboardData
            );
        }
    });

});
</script>
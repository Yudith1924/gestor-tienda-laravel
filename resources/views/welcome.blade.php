<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Inicio</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    </head>
    <body style="margin: 0; font-family: 'Instrument Sans', system-ui, sans-serif; background-color: #f4f7f6; color: #1e293b; min-height: 100vh; display: flex; flex-direction: column;">

        <header style="background-color: #ffffff; padding: 18px 40px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; box-shadow: 0 1px 2px rgba(0,0,0,0.01);">
            <div style="font-size: 1.4rem; font-weight: 700; color: #0f172a; letter-spacing: -0.5px;">
                Super
            </div>
            
            @if (Route::has('login'))
                <nav style="display: flex; gap: 12px; align-items: center;">
                    @auth
                        <a href="{{ url('/dashboard') }}" style="background-color: #064e3b; color: #ffffff; text-decoration: none; padding: 10px 18px; border-radius: 10px; font-weight: 600; font-size: 0.9rem; box-shadow: 0 4px 6px -1px rgba(6, 78, 59, 0.15);">
                            Ir al Panel de Control
                        </a>
                    @else
                        <a href="{{ route('login') }}" style="color: #475569; text-decoration: none; padding: 10px 16px; font-weight: 600; font-size: 0.9rem;">
                            Ingresar
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" style="background-color: #ffffff; color: #0f172a; text-decoration: none; padding: 10px 18px; border-radius: 10px; border: 1px solid #e2e8f0; font-weight: 600; font-size: 0.9rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                Registrarse
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <main style="flex-grow: 1; display: flex; align-items: center; justify-content: center; padding: 40px 20px;">
            <div style="background-color: #ffffff; max-width: 550px; width: 100%; padding: 48px; border-radius: 20px; text-align: center; border: 1px solid #e2e8f0; box-shadow: 0 4px 20px -2px rgba(0,0,0,0.03);">
                
                
                <h1 style="font-size: 2.2rem; font-weight: 700; color: #0f172a; margin: 0 0 14px 0; line-height: 1.25; letter-spacing: -0.5px;">
                    La forma más rápida de comprar y vender
                </h1>
                
                <p style="color: #64748b; font-size: 1.05rem; line-height: 1.5; margin: 0 0 36px 0;">
                    Bienvenido a la demostración de tu e-commerce interactivo en tiempo real. Explora los productos disponibles de inmediato o inicia sesión para gestionar tu stock.
                </p>

                <div style="display: flex; flex-direction: column; gap: 14px;">
                    <a href="/tienda" style="background-color: #10b981; color: #ffffff; text-decoration: none; padding: 14px; border-radius: 12px; font-weight: 600; font-size: 1.05rem; box-shadow: 0 4px 12px -1px rgba(16, 185, 129, 0.25); transition: background 0.2s;">
                        Entrar a la Tienda 
                    </a>
                    
                    @guest
                        <p style="margin: 16px 0 4px 0; font-size: 0.8rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px;">¿Eres administrador?</p>
                        <a href="{{ route('login') }}" style="background-color: #f8fafc; color: #1e293b; text-decoration: none; padding: 14px; border-radius: 12px; font-weight: 600; font-size: 0.95rem; border: 1px solid #e2e8f0;">
                            Acceder al Modo Vendedor
                        </a>
                    @endguest
                </div>
            </div>
        </main>

        <footer style="text-align: center; padding: 24px; color: #64748b; font-size: 0.85rem; background-color: #ffffff; border-top: 1px solid #e2e8f0;">
            &copy; {{ date('Y') }} ComprasSuper. Desarrollado localmente con Laravel Herd.
        </footer>

    </body>
</html>
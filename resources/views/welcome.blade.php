<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nombre de tu Proyecto - El Reto</title>
    @stack('styles')
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        /* Personalización de colores para que combine con tu marca */
        :root {
            --brand-primary: #e30613; /* Rojo Bodega */
            --brand-secondary: #000000;
        }
        .bg-brand { background-color: var(--brand-primary); }
        .text-brand { color: var(--brand-primary); }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-900" x-data="{ section: 'home' }">

    <nav class="fixed top-0 w-full bg-white shadow-md z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="font-bold text-2xl text-brand">TU LOGO</div>
            <div class="hidden md:flex space-x-6 font-semibold uppercase text-sm">
                <a href="#mecanica" class="hover:text-brand transition">Mecánica</a>
                <a href="#premios" class="hover:text-brand transition">Premios</a>
                <a href="#ranking" class="hover:text-brand transition">Ranking</a>
            </div>
            <button onclick="window.location='{{ route('login') }}'" class="bg-brand text-white px-6 py-2 rounded-full font-bold hover:opacity-90 transition">
                Login
            </button>
        </div>
    </nav>

    <header class="pt-24 pb-12 bg-brand text-white">
        <div class="max-w-5xl mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-black italic uppercase mb-4">
                ¡Prepárate para la nueva misión!
            </h1>
            <p class="text-lg md:text-xl mb-8">
                Supera los obstáculos, registra tu ticket y compite por grandes premios.
            </p>
            <div class="bg-white p-4 rounded-lg inline-block text-black font-bold">
                CÓDIGO DE LA ISLA: <span class="text-brand">0000-0000-0000</span>
            </div>
        </div>
    </header>

    <section id="mecanica" class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-12 uppercase">¿Cómo participar?</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-6 border-2 border-gray-100 rounded-xl hover:border-brand transition">
                    <div class="text-4xl text-brand mb-4"><i class="fas fa-shopping-cart"></i></div>
                    <h3 class="font-bold text-xl mb-2">Paso 1</h3>
                    <p class="text-gray-600">Haz una compra mínima en nuestras tiendas participantes.</p>
                </div>
                <div class="p-6 border-2 border-gray-100 rounded-xl hover:border-brand transition">
                    <div class="text-4xl text-brand mb-4"><i class="fas fa-file-alt"></i></div>
                    <h3 class="font-bold text-xl mb-2">Paso 2</h3>
                    <p class="text-gray-600">Registra tu ticket y tus datos en nuestro formulario.</p>
                </div>
                <div class="p-6 border-2 border-gray-100 rounded-xl hover:border-brand transition">
                    <div class="text-4xl text-brand mb-4"><i class="fas fa-gamepad"></i></div>
                    <h3 class="font-bold text-xl mb-2">Paso 3</h3>
                    <p class="text-gray-600">Juega en Fortnite y sube tu mejor tiempo con una captura.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="premios" class="py-16 bg-gray-900 text-white">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-12 uppercase italic">Grandes Premios</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 text-black">
                <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-laptop text-5xl text-gray-400"></i>
                    </div>
                    <div class="p-4 bg-yellow-400 font-black uppercase italic">1er Lugar</div>
                    <div class="p-4 text-left">
                        <ul class="text-sm space-y-1">
                            <li>• Laptop Gaming de última generación</li>
                            <li>• Teclado mecánico Pro</li>
                            <li>• Monitor 4K</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="ranking" class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8 text-center uppercase">Ranking en Tiempo Real</h2>
            <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 uppercase text-xs font-bold text-gray-500">
                        <tr>
                            <th class="px-6 py-4">Posición</th>
                            <th class="px-6 py-4">Participante</th>
                            <th class="px-6 py-4">Puntaje</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($ranking as $index => $intento)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-black italic text-xl 
                                    {{ $index + 1 == 1 ? 'text-yellow-500' : ($index + 1 == 2 ? 'text-gray-400' : ($index + 1 == 3 ? 'text-amber-600' : 'text-gray-600')) }}">
                                    {{ $index + 1 }}
                                </td>
                                
                                <td class="px-6 py-4 font-semibold text-gray-700 italic">
                                    {{ $intento->user->nickname ?? 'Gamer Anónimo' }}
                                </td>
                                
                                <td class="px-6 py-4 font-mono font-bold text-brand">
                                    {{ number_format($intento->mejor_puntaje) }} pts
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-400 italic">
                                    ¡El reto acaba de iniciar! Sé el primero en registrar tu puntaje.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <p class="text-xs text-gray-400 mt-4 text-center italic">
                * Los resultados están en proceso de validación.
            </p>
        </div>
    </section>

    <footer class="bg-gray-100 py-12 border-t border-gray-200">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <div class="flex justify-center space-x-6 mb-6 text-sm font-bold text-gray-600">
                <a href="#" class="hover:text-brand transition">CONTACTO</a>
                <a href="#" class="hover:text-brand transition">TÉRMINOS Y CONDICIONES</a>
                <a href="#" class="hover:text-brand transition">AVISO DE PRIVACIDAD</a>
            </div>
            <p class="text-xs text-gray-400 uppercase">
                &copy; 2026 Tu Proyecto. Esta iniciativa no está patrocinada por Epic Games, Inc.
            </p>
        </div>
    </footer>

</body>
</html>
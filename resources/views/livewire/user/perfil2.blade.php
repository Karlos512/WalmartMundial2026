<div class="min-h-screen bg-gray-900 text-white p-6 md:p-12 font-sans">

    <!-- Encabezado -->
    <header class="max-w-6xl mx-auto mb-10 flex justify-between items-end border-b border-gray-800 pb-6">
        <div>
            <p class="text-red-600 font-black uppercase tracking-tighter text-xs">Panel de Participante</p>
            <h1 class="text-3xl font-black italic uppercase italic">
                BIENVENIDO, <span class="text-white">{{ $nickname }}</span>
            </h1>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-[10px] font-black uppercase italic bg-gray-800 hover:bg-red-600 border border-gray-700 px-4 py-2 rounded-lg transition-all flex items-center gap-2">
                Cerrar Sesión <i class="fas fa-sign-out-alt"></i>
            </button>
        </form>
    </header>

    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-6">

        <!-- TARJETA DE ACCIÓN (JUEGO) -->
        <div class="bg-gray-800/50 rounded-3xl border border-gray-700 p-8 flex flex-col items-center justify-center min-h-[350px] relative overflow-hidden">
            <div class="relative z-10 text-center">
                <div class="w-20 h-20 bg-red-600/10 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-600/20">
                    <i class="fas fa-gamepad text-3xl text-red-600"></i>
                </div>
                <h2 class="text-xl font-black uppercase italic mb-1">¡A darle al juego!</h2>
                <p class="text-gray-500 text-xs font-bold uppercase mb-8">Tienes intentos listos para usar</p>

                <!-- Botón más pequeño y estilizado -->
                <a href="#" wire:click='saveScore()' class="inline-block bg-red-600 hover:bg-red-700 text-white font-black italic uppercase text-sm px-10 py-3 rounded-xl transition-all shadow-[0_10px_20px_rgba(220,38,38,0.2)] hover:scale-105 active:scale-95">
                    ¡A Jugar!
                </a>
            </div>

            <!-- Marca de agua sutil -->
            <i class="fas fa-lock absolute -top-4 -right-4 text-gray-700/20 text-8xl"></i>
        </div>

        <!-- TARJETA DE PUNTAJE (SCORE) -->
        <div class="bg-black rounded-3xl border-2 border-red-600/20 p-8 flex flex-col items-center justify-center min-h-[350px] relative">

            <div class="text-center relative z-10">
                <h2 class="text-gray-500 font-black uppercase tracking-widest text-[10px] mb-6">Tu Mejor Puntaje</h2>

                <!-- Contenedor de puntaje para balancear el peso -->
                <div class="bg-gray-900/50 border border-gray-800 rounded-2xl px-10 py-6 mb-6 inline-block">
                    <span class="text-6xl md:text-7xl font-mono font-black text-white italic tracking-tighter">
                        {{ number_format($mejorPuntaje) }}
                    </span>
                    <span class="text-red-600 font-black italic text-xl ml-2">PTS</span>
                </div>

                <div class="flex items-center justify-center space-x-2 bg-red-600/10 px-4 py-1.5 rounded-full border border-red-600/20 w-fit mx-auto">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-600"></span>
                    </span>
                    <span class="text-[9px] font-black text-red-500 uppercase tracking-widest">Ranking en vivo</span>
                </div>
            </div>

            <!-- Icono de cronómetro mejor posicionado -->
            <i class="fas fa-stopwatch absolute top-6 right-8 text-gray-800/30 text-5xl"></i>
        </div>

    </div>
</div>

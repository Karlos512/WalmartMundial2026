<div>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('juego/css/styles.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet" />
    @endpush

    <div class="min-h-screen bg-gray-900 text-white p-6 md:p-12 font-sans">

        <header class="max-w-4xl mx-auto mb-10 flex flex-col sm:flex-row justify-between items-start sm:items-end border-b border-gray-800 pb-6 gap-4">

            <div>

                <p class="text-red-600 font-black uppercase tracking-tighter text-xs">
                    Panel de Participante
                </p>

                <h1 class="text-3xl font-black italic uppercase">
                    BIENVENIDO,
                    <span class="text-white">{{ $nickname }}</span>
                </h1>

                <div class="mt-2 flex items-center gap-2 bg-gray-800/40 border border-gray-800 rounded-xl px-4 py-1.5 w-fit">

                    <span class="text-gray-500 font-black uppercase tracking-widest text-[9px]">
                        Mejor Puntaje:
                    </span>

                    <span class="text-xl font-mono font-black text-white italic tracking-tighter">
                        {{ number_format($mejorPuntaje) }}
                    </span>

                    <span class="text-red-600 font-black italic text-xs">
                        PTS
                    </span>

                </div>

            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    class="text-[10px] font-black uppercase italic bg-gray-800 hover:bg-red-600 border border-gray-700 px-4 py-2 rounded-lg transition-all flex items-center gap-2"
                >
                    Cerrar Sesión
                </button>

            </form>

        </header>

        <div class="max-w-4xl mx-auto">

            {{-- PANTALLA INICIAL --}}
            <div
                id="introWrapper"
                class="{{ $jugando ? 'hidden' : '' }}"
            >

                <div class="bg-gray-800/50 rounded-3xl border border-gray-700 p-8 flex flex-col items-center justify-center min-h-[420px]">

                    <div class="text-center py-6">

                        <div class="w-20 h-20 bg-red-600/10 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-600/20">
                            <i class="fas fa-gamepad text-3xl text-red-600"></i>
                        </div>

                        <h2 class="text-2xl font-black uppercase italic mb-4">
                            ¡A darle al juego!
                        </h2>

                        @if(\App\Models\Parametros::where('parametro', 'juego_activo')->value('activo'))
                            <button wire:click="iniciarIntento"
                                    wire:loading.attr="disabled"
                                    class="inline-block bg-red-600 hover:bg-red-700 text-white font-black italic uppercase text-sm px-12 py-3.5 rounded-xl transition-all transform hover:scale-[1.02] active:scale-95 disabled:opacity-50">
                                <span wire:loading.remove wire:target="iniciarIntento">¡A Jugar!</span>
                                <span wire:loading wire:target="iniciarIntento"><i class="fas fa-circle-notch animate-spin mr-2"></i> Cargando...</span>
                            </button>
                        @else
                            <button disabled 
                                    class="inline-block bg-gray-800 text-gray-500 font-black italic uppercase text-sm px-12 py-3.5 rounded-xl border border-gray-700 cursor-not-allowed">
                                Juego Pausado
                            </button>
                        @endif

                    </div>

                </div>

            </div>

            {{-- JUEGO --}}
            <div
                id="gameWrapper"
                class="{{ !$jugando ? 'hidden' : '' }}"
            >

                <div
                    id="gameContainer"
                    class="game-container w-full"
                    wire:ignore
                >

                    <div class="header mb-4">

                        <div class="score-container">

                            <div class="best-display">
                                TIME:
                                <span id="timer">60</span>s
                            </div>

                            <div class="score-display">
                                SCORE:
                                <span id="currentScore">0</span>
                            </div>

                            <div class="best-display hidden">
                                BEST:
                                <span id="bestScore">0</span>
                            </div>

                        </div>

                    </div>

                    <div class="board-container">

                        <div id="board" class="game-board"></div>

                        <div class="timer-container mt-3">
                            <div id="timerBar" class="timer-bar"></div>
                        </div>

                    </div>

                    <div id="welcomeScreen" class="welcome-screen">

                        <button
                            id="startBtn"
                            class="play-button uppercase font-black italic"
                        >
                            ¡EMPEZAR YA!
                        </button>

                    </div>

                    <div id="gameOver" class="game-over hidden">
                        <div class="game-over-content text-center">
                            <h2 class="text-red-500 font-black italic text-2xl uppercase">
                                ¡TIEMPO AGOTADO!
                            </h2>

                            <p class="text-sm font-bold text-gray-400 mt-2">
                                Puntaje obtenido:
                                <span id="finalScore" class="text-white font-mono font-black text-xl">
                                    0
                                </span>
                            </p>

                            <div class="mt-5">
                                <button 
                                    id="btnCompartirFB"
                                    class="inline-flex items-center justify-center bg-[#1877F2] hover:bg-[#166FE5] text-white font-bold text-sm px-4 py-2.5 rounded-lg transition-colors duration-200 shadow-md"
                                >
                                    <svg class="w-4 h-4 mr-2 fill-current" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                    Compartir en Facebook
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>



<script src="{{ asset('juego/js/game.js') }}"></script>

<script>
    (() => {
        let juegoActivo = null;
        let tokenPartidaActual = null;

        document.addEventListener('livewire:init', () => {
            
            Livewire.on('iniciar-juego', (data) => {
                tokenPartidaActual = data[0]?.token || data?.token || null;

                // Limpieza visual del DOM para que aparezca el tablero limpio
                document.getElementById('gameOver')?.classList.add('hidden');
                document.getElementById('welcomeScreen')?.classList.add('hidden'); 
                document.getElementById('currentScore').innerText = '0';
                document.getElementById('finalScore').innerText = '0';
                document.getElementById('timer').innerText = '60';
                
                const board = document.getElementById('board');
                if (board) board.innerHTML = ''; // Se limpia el contenedor para el nuevo tablero

                if (typeof window.__ArrancarCandyGameNativo === 'function') {
                    if (juegoActivo) {
                        try { juegoActivo.destroy(); } catch(e) { console.error(e); }
                        juegoActivo = null;
                    }

                    // Arrancamos la instancia nativa del juego
                    juegoActivo = window.__ArrancarCandyGameNativo(tokenPartidaActual);

                    setTimeout(() => {
                        juegoActivo.startBtn?.click();
                    }, 100);
                }
            });

            const btnFB = document.getElementById('btnCompartirFB');
            if (btnFB) {
                btnFB.onclick = function() {
                    const urlCompartir = encodeURIComponent(window.location.href);
                    const fbShareUrl = `https://www.facebook.com/sharer/sharer.php?u=${urlCompartir}`;
                    
                    const width = 600;
                    const height = 400;
                    const left = (window.screen.width / 2) - (width / 2);
                    const top = (window.screen.height / 2) - (height / 2);
                    
                    window.open(
                        fbShareUrl, 
                        'Compartir Récord', 
                        `width=${width},height=${height},top=${top},left=${left},toolbar=no,menubar=no,scrollbars=yes,resizable=yes`
                    );
                };
            }
        });

        window.__DespacharScoreSeguro = function(scoreFinal) {
            if (tokenPartidaActual && window.Livewire) {
                Livewire.dispatch('guardar-score', { 
                    score: parseInt(scoreFinal), 
                    token: tokenPartidaActual 
                });
                tokenPartidaActual = null;
            }
        };
    })();
</script>

</div>


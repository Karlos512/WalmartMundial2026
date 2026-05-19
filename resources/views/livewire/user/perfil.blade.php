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
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </header>

        <div class="max-w-4xl mx-auto">

            <div class="bg-gray-800/50 rounded-3xl border border-gray-700 p-8 flex flex-col items-center justify-center min-h-[420px] relative overflow-hidden shadow-2xl">

                @if(!$jugando)

                    <div class="relative z-10 text-center py-6">

                        <div class="w-20 h-20 bg-red-600/10 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-600/20">
                            <i class="fas fa-gamepad text-3xl text-red-600"></i>
                        </div>

                        <h2 class="text-2xl font-black uppercase italic mb-1">
                            ¡A darle al juego!
                        </h2>

                        @if(session()->has('error_juego'))
                            <p class="text-red-500 text-[10px] font-black uppercase mb-4 italic">
                                {{ session('error_juego') }}
                            </p>
                        @endif

                        <button
                            wire:click="iniciarIntento"
                            class="inline-block bg-red-600 hover:bg-red-700 text-white font-black italic uppercase text-sm px-12 py-3.5 rounded-xl transition-all shadow-[0_10px_20px_rgba(220,38,38,0.2)] hover:scale-105 active:scale-95"
                        >
                            ¡A Jugar!
                        </button>

                    </div>

                @else

                    <div id="gameContainer" class="game-container w-full" wire:ignore>
                        <div class="header mb-4">

                            <div class="score-container">

                                <div class="best-display">
                                    TIME:
                                    <span id="timer" class="font-mono">60</span>s
                                </div>

                                <div class="score-display">
                                    SCORE:
                                    <span id="currentScore">0</span>
                                </div>

                                <div class="best-display">
                                    BEST:
                                    <span id="bestScore">0</span>
                                </div>

                            </div>

                            <div class="controls">
                                <button id="pauseBtn" class="control-btn pause-btn">
                                    <span></span>
                                </button>
                            </div>

                        </div>

                        <div class="board-container">

                            <div id="board" class="game-board"></div>

                            <div class="timer-container mt-3">
                                <div id="timerBar" class="timer-bar"></div>
                            </div>

                        </div>

                        <div id="welcomeScreen" class="welcome-screen">
                            <button id="startBtn" class="play-button uppercase font-black italic">
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

                                <div class="mt-4 flex justify-center items-center gap-2 text-red-500 text-[10px] font-black uppercase tracking-wider animate-pulse">
                                    <i class="fas fa-spinner animate-spin"></i>
                                    Guardando puntuación...
                                </div>

                            </div>

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>

    <script>
        function iniciarJuego() {

            const board = document.getElementById('board');

            if (!board) {
                console.error('Board no encontrado');
                return;
            }

            // Evita duplicados
            if (window.gameInstance) {
                console.log('Juego ya inicializado');
                return;
            }

            const iniciarInstancia = () => {

                try {

                    if (!window.CandyGame) {
                        console.error('CandyGame no está disponible');
                        return;
                    }

                    console.log('Inicializando CandyGame');

                    window.gameInstance = new window.CandyGame();
                    window.gameInstance.startBtn?.click();

                    console.log('CandyGame inicializado');

                } catch (e) {

                    console.error('Error creando CandyGame:', e);

                }
            };

            // Ya cargado
            if (window.CandyGame) {
                iniciarInstancia();
                return;
            }

            if (document.getElementById('game-script')) {
                return;
            }

            const script = document.createElement('script');

            script.id = 'game-script';
            script.type = 'module';
            script.src = "{{ asset('juego/js/game.js') }}";

            script.onload = () => {

                console.log('game.js cargado');

                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        iniciarInstancia();
                    });
                });

            };

            script.onerror = (e) => {
                console.error('Error cargando game.js', e);
            };

            document.body.appendChild(script);
        }

        document.addEventListener('livewire:init', () => {

            Livewire.on('iniciar-juego', () => {

                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        iniciarJuego();
                    });
                });

            });

        });
    </script>

</div>
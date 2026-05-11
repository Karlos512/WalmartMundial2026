<div class="min-h-screen bg-gray-900 text-white p-6 md:p-12 font-sans">

    <!-- Encabezado -->
    <header class="max-w-5xl mx-auto mb-10">
        <h1 class="text-3xl font-black italic uppercase italic">
            BIENVENIDO, <span class="text-red-600">{{ $username }}</span>
        </h1>
    </header>

    <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-8">

        {{-- <div class="bg-gray-800 p-8 rounded-3xl border border-gray-700 shadow-2xl relative overflow-hidden">

            @if($this->puedeSubirTicket)
                <h2 class="text-xl font-bold mb-6 uppercase flex items-center">
                    <i class="fas fa-receipt mr-2 text-red-600"></i> Registra tu Ticket
                </h2>

                <form wire:submit.prevent="guardar" class="space-y-6">
                    <div class="relative group">
                        @if ($ticket)
                            <div class="relative w-full h-64 rounded-2xl overflow-hidden border-2 border-red-600">
                                <img src="{{ $ticket->temporaryUrl() }}" class="w-full h-full object-cover">
                                <button type="button" wire:click="$set('ticket', null)" class="absolute top-2 right-2 bg-black/50 p-2 rounded-full hover:bg-red-600 transition">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @else
                            <label class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed border-gray-600 rounded-2xl cursor-pointer hover:border-red-600 hover:bg-gray-700/50 transition">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-500 mb-3 group-hover:text-red-600"></i>
                                    <p class="text-sm text-gray-400 font-bold uppercase">Haz clic para subir foto</p>
                                    <p class="text-xs text-gray-500 mt-1">PNG, JPG (Máx. 2MB)</p>
                                </div>
                                <input type="file" wire:model="ticket" class="hidden" accept="image/*">
                            </label>
                        @endif

                        <div wire:loading wire:target="ticket" class="absolute inset-0 bg-gray-900/80 rounded-2xl flex items-center justify-center">
                            <span class="text-sm font-bold animate-pulse text-red-600">PROCESANDO IMAGEN...</span>
                        </div>
                    </div>

                    @error('ticket') <span class="text-red-500 text-xs font-bold uppercase">{{ $message }}</span> @enderror

                    @if (session()->has('message'))
                        <div class="bg-green-600/20 text-green-400 p-4 rounded-xl text-sm font-bold text-center">
                            {{ session('message') }}
                        </div>
                    @endif

                    <button type="submit"
                        @if(!$ticket) disabled @endif
                        class="w-full py-4 bg-red-600 hover:bg-red-700 disabled:bg-gray-700 disabled:cursor-not-allowed text-white font-black italic uppercase rounded-xl transition-all transform hover:scale-[1.02] active:scale-95 shadow-lg shadow-red-900/20">
                        Enviar Ticket para Validación
                    </button>
                </form>
            @else
                <div class="flex flex-col items-center justify-center py-10 space-y-4">
                    <div class="bg-red-600/20 p-6 rounded-full border border-red-600/40">
                        <i class="fas fa-gamepad text-5xl text-red-600 animate-bounce"></i>
                    </div>
                    <div class="text-center">
                        <h2 class="text-xl font-black uppercase italic text-white">¡A darle al juego!</h2>
                        <p class="text-gray-400 text-sm mt-2 max-w-[250px]">
                            Ya tienes intentos disponibles. Úsalos todos para poder registrar un nuevo ticket.
                        </p>
                    </div>

                    <div class="bg-gray-900 px-6 py-3 rounded-2xl border border-gray-700">
                        <span class="text-red-500 font-black text-2xl">{{ $this->intentos }}</span>
                        <span class="text-gray-500 text-xs font-bold uppercase ml-2 tracking-tighter">Vidas listas</span>
                    </div>
                </div>

                <div class="absolute top-0 right-0 p-4">
                    <i class="fas fa-lock text-gray-700/30 text-4xl"></i>
                </div>
            @endif
        </div> --}}

        {{-- --------------------------------- --}}
        <div class="bg-gray-800 p-8 rounded-3xl border border-gray-700 shadow-2xl relative overflow-hidden">
            <div class="flex flex-col items-center justify-center py-10 space-y-4">
                <div class="bg-red-600/20 p-6 rounded-full border border-red-600/40">
                    <i class="fas fa-gamepad text-5xl text-red-600 animate-bounce"></i>
                </div>
                <div class="text-center">
                    <h2 class="text-xl font-black uppercase italic text-white">¡A darle al juego!</h2>
                    <p class="text-gray-400 text-sm mt-2 max-w-[250px]">
                        Ya tienes intentos disponibles.
                    </p>
                </div>

                <div class="mt-10 w-full">
                        <a href="/minijuego"
                           class="group relative inline-flex items-center justify-center w-full p-0.5 mb-2 mr-2 overflow-hidden text-sm font-black uppercase italic rounded-2xl group bg-gradient-to-br from-yellow-400 via-red-600 to-red-700 group-hover:from-yellow-400 group-hover:to-red-700 text-white focus:ring-4 focus:outline-none focus:ring-red-800 shadow-[0_0_20px_rgba(220,38,38,0.5)]">
                            <span class="relative w-full px-5 py-6 transition-all ease-in duration-75 bg-gray-900 rounded-xl group-hover:bg-opacity-0 flex flex-col items-center">
                                <span class="text-3xl mb-1">¡A JUGAR!</span>
                                {{-- <span class="text-xs opacity-70">Tienes {{ $this->intentos }} {{ $this->intentos == 1 ? 'intento disponible' : 'intentos disponibles' }}</span> --}}
                            </span>
                        </a>
                </div>

            </div>

            <div class="absolute top-0 right-0 p-4">
                <i class="fas fa-lock text-gray-700/30 text-4xl"></i>
            </div>

    </div>

        {{-- --------------------------------- --}}

        <!-- SECCIÓN MEJOR TIEMPO -->
        <div class="bg-black p-8 rounded-3xl border-2 border-red-600/30 flex flex-col items-center justify-center relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <i class="fas fa-stopwatch text-9xl"></i>
            </div>

            <h2 class="text-gray-500 font-bold uppercase tracking-widest mb-2">Tu Mejor Puntaje</h2>
            <div class="text-6xl md:text-7xl font-mono font-black text-white italic">
                {{ number_format($mejorPuntaje) }} pts
            </div>

            {{-- <h2 class="text-gray-500 font-bold uppercase tracking-widest mb-2">Tu Record Personal</h2>
            <div class="text-6xl md:text-7xl font-mono font-black text-white italic">
                {{ $mejorTiempo }}
            </div> --}}

            <div class="mt-8 flex items-center space-x-2 bg-red-600/10 px-4 py-2 rounded-full border border-red-600/20">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-600"></span>
                </span>
                <span class="text-xs font-bold text-red-500 uppercase">Ranking en vivo</span>
            </div>
        </div>

    </div>

    {{-- Seccion boton jugafr --}}
    {{-- <div class="mt-10 w-full">
        @if($this->intentos > 0)
            <a href="/minijuego"
               class="group relative inline-flex items-center justify-center w-full p-0.5 mb-2 mr-2 overflow-hidden text-sm font-black uppercase italic rounded-2xl group bg-gradient-to-br from-yellow-400 via-red-600 to-red-700 group-hover:from-yellow-400 group-hover:to-red-700 text-white focus:ring-4 focus:outline-none focus:ring-red-800 shadow-[0_0_20px_rgba(220,38,38,0.5)]">
                <span class="relative w-full px-5 py-6 transition-all ease-in duration-75 bg-gray-900 rounded-xl group-hover:bg-opacity-0 flex flex-col items-center">
                    <span class="text-3xl mb-1">¡A JUGAR!</span>
                    <span class="text-xs opacity-70">Tienes {{ $this->intentos }} {{ $this->intentos == 1 ? 'intento disponible' : 'intentos disponibles' }}</span>
                </span>
            </a>

            <p class="text-center text-[10px] text-green-400 font-bold uppercase tracking-widest mt-2 animate-pulse">
                <i class="fas fa-check-circle mr-1"></i> Acceso concedido por tus tickets
            </p>

        @else
            <div class="relative w-full p-6 rounded-2xl bg-gray-800 border-2 border-dashed border-gray-700 flex flex-col items-center opacity-60">
                <i class="fas fa-lock text-3xl text-gray-600 mb-2"></i>
                <span class="text-xl font-black uppercase italic text-gray-500 text-center">Juego Bloqueado</span>
                <p class="text-[10px] text-gray-500 text-center uppercase font-bold mt-2">
                    Sube un ticket y espera a que sea aprobado para ganar intentos.
                </p>
            </div>
        @endif
    </div> --}}


</div>




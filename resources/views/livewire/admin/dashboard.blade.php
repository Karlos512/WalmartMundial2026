<div class="min-h-screen bg-gray-900 text-white p-6 md:p-12 font-sans">

    <!-- Header Admin -->
    <header class="max-w-7xl mx-auto mb-10 flex justify-between items-center border-b border-gray-800 pb-6">
        <div>
            <h1 class="text-3xl font-black italic uppercase">Admin<span class="text-red-600">Control</span></h1>
            <p class="text-gray-500 text-xs font-bold uppercase tracking-widest">Resumen General del Sistema</p>
        </div>

        <div class="flex gap-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-gray-400 text-[10px] font-black uppercase px-4 py-2 rounded-lg border border-gray-700">
                    Salir
                </button>
            </form>
        </div>
    </header>

    <main class="max-w-7xl mx-auto">

        <!-- Grid de Estadísticas Rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">

            <!-- Total Participantes -->
            <div class="bg-gray-800 border border-gray-700 p-6 rounded-2xl shadow-xl">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-blue-600/10 rounded-xl">
                        <i class="fas fa-users text-blue-600"></i>
                    </div>
                    <span class="text-[10px] font-bold text-green-500 bg-green-500/10 px-2 py-1 rounded">+{{ $nuevosHoy }} hoy</span>
                </div>
                <h3 class="text-gray-500 text-xs font-black uppercase tracking-tighter">Participantes</h3>
                <p class="text-4xl font-mono font-black italic">{{ number_format($totalUsuarios) }}</p>
            </div>

            <!-- Tickets Pendientes 
            <div class="bg-gray-800 border border-gray-700 p-6 rounded-2xl shadow-xl">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-yellow-600/10 rounded-xl">
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                </div>
                <h3 class="text-gray-500 text-xs font-black uppercase tracking-tighter">Puntajes Por Validar</h3>
                <p class="text-4xl font-mono font-black italic text-yellow-500">{{ $puntajePendiente }}</p>
            </div>-->

            <!-- Intentos Realizados -->
            <div class="bg-gray-800 border border-gray-700 p-6 rounded-2xl shadow-xl">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-purple-600/10 rounded-xl">
                        <i class="fas fa-gamepad text-purple-600"></i>
                    </div>
                </div>
                <h3 class="text-gray-500 text-xs font-black uppercase tracking-tighter">Partidas Jugadas</h3>
                <p class="text-4xl font-mono font-black italic">{{ $totalPartidas }}</p>
            </div>

            <!-- Puntaje Máximo Global -->
            <div class="bg-gray-800 border border-gray-700 p-6 rounded-2xl shadow-xl border-l-4 border-l-red-600">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-red-600/10 rounded-xl">
                        <i class="fas fa-trophy text-red-600"></i>
                    </div>
                </div>
                <h3 class="text-gray-500 text-xs font-black uppercase tracking-tighter">Récord Global</h3>
                <p class="text-4xl font-mono font-black italic text-red-600">{{ number_format($recordGlobal) }}</p>
            </div>

        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <!-- Tabla de Últimos Registros -->
            <div class="md:col-span-2 bg-gray-800 border border-gray-700 rounded-3xl p-8">
                <h3 class="text-lg font-black uppercase italic mb-6">Nuevos Participantes</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="text-gray-500 border-b border-gray-700">
                                <th class="pb-4 font-black uppercase italic text-xs">Usuario</th>
                                <th class="pb-4 font-black uppercase italic text-xs">Ubicación</th>
                                <th class="pb-4 font-black uppercase italic text-xs">Registro</th>
                                <th class="pb-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700/50">
                            @foreach($ultimosUsuarios as $u)
                            <tr>
                                <td class="py-4">
                                    <div class="font-bold">{{ $u->name }}</div>
                                    <div class="text-[10px] text-gray-500">{{ $u->email }}</div>
                                </td>
                                <td class="py-4 text-gray-400">{{ $u->ciudad }}, {{ $u->estado }}</td>
                                <td class="py-4 text-gray-400 text-xs">{{ $u->created_at->diffForHumans() }}</td>
                                <td class="py-4 text-right">
                                    <button class="text-red-600 hover:text-white transition"><i class="fas fa-eye"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Acciones Rápidas / Configuración -->
            <div class="bg-black border border-gray-700 rounded-3xl p-8 flex flex-col gap-4">
                <h3 class="text-lg font-black uppercase italic mb-2">Controles</h3>

                <button class="w-full py-4 bg-gray-800 hover:bg-red-600 rounded-xl text-xs font-black uppercase italic transition-all border border-gray-700">
                    <i class="fas fa-file-excel mr-2"></i> Exportar Participantes
                </button>

                @if(!$mostrarAjustes)
                    <button wire:click="toggleBloqueAjustes" class="w-full py-4 bg-gray-800 hover:bg-blue-600 rounded-xl text-xs font-black uppercase italic transition-all border border-gray-700">
                        <i class="fas fa-cog mr-2"></i> Ajustes del Concurso
                    </button>
                @else
                    <div class="bg-gray-900 border border-gray-700 p-4 rounded-2xl space-y-4 animate-fadeIn">
                        <div class="flex justify-between items-center border-b border-gray-800 pb-2">
                            <span class="text-xs font-black uppercase italic text-blue-500">Configuraciones</span>
                            <button wire:click="toggleBloqueAjustes" class="text-gray-500 hover:text-white text-xs"><i class="fas fa-times"></i></button>
                        </div>

                        @if (session()->has('status_ajustes'))
                            <p class="text-[10px] text-green-500 font-bold bg-green-500/10 p-2 rounded text-center">{{ session('status_ajustes') }}</p>
                        @endif

                        <div class="flex items-center justify-between bg-gray-800 p-3 rounded-xl border border-gray-700">
                            <div>
                                <p class="text-xs font-bold text-white">Nuevos Registros</p>
                                <p class="text-[10px] text-gray-500">Permitir inscripciones</p>
                            </div>
                            <input type="checkbox" wire:model.live="registroActivo" wire:change="actualizarRegistro" class="w-4 h-4 accent-blue-600 cursor-pointer">
                        </div>

                        <div class="flex items-center justify-between bg-gray-800 p-3 rounded-xl border border-gray-700">
                            <div>
                                <p class="text-xs font-bold text-white">Botón de Jugar</p>
                                <p class="text-[10px] text-gray-500">Habilitar sala de juego</p>
                            </div>
                            <input type="checkbox" wire:model.live="juegoActivo" wire:change="actualizarJuego" class="w-4 h-4 accent-red-600 cursor-pointer">
                        </div>
                    </div>
                @endif

                <div class="mt-auto p-4 bg-red-600/5 rounded-2xl border border-red-600/20 text-center">
                    <p class="text-[10px] font-bold text-red-500 uppercase mb-1">Estado del Servidor</p>
                    <p class="text-xs text-white">Online - Operando Normal</p>
                </div>
            </div>
        </div>
    </main>
</div>

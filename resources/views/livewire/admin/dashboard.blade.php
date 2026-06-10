<div class="min-h-screen bg-gray-900 text-white p-6 md:p-12 font-sans">

    <header class="max-w-7xl mx-auto mb-10 flex justify-between items-center border-b border-gray-800 pb-6">
        <div>
            <h1 wire:click="irAVista('dashboard')" class="text-3xl font-black italic uppercase cursor-pointer select-none">
                Admin<span class="text-red-600">Control</span>
            </h1>
            <p class="text-gray-500 text-xs font-bold uppercase tracking-widest">
                @if($vistaActual == 'dashboard') Resumen General @elseif($vistaActual == 'participantes') Lista de Competidores @else Auditoría de Partidas @endif
            </p>
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
        
        @if (session()->has('global_msg'))
            <div class="bg-blue-600 border border-blue-500 text-white px-4 py-3 rounded-xl mb-6 text-sm font-bold text-center shadow-lg uppercase italic tracking-wider">
                {{ session('global_msg') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-gray-800 border border-gray-700 p-6 rounded-2xl shadow-xl">
                <div class="flex justify-between items-start mb-4"><div class="p-3 bg-blue-600/10 rounded-xl"><i class="fas fa-users text-blue-600"></i></div><span class="text-[10px] font-bold text-green-500 bg-green-500/10 px-2 py-1 rounded">+{{ $nuevosHoy }} hoy</span></div>
                <h3 class="text-gray-500 text-xs font-black uppercase tracking-tighter">Participantes</h3>
                <p class="text-4xl font-mono font-black italic">{{ number_format($totalUsuarios) }}</p>
            </div>
            <div class="bg-gray-800 border border-gray-700 p-6 rounded-2xl shadow-xl"><div class="flex justify-between items-start mb-4"><div class="p-3 bg-purple-600/10 rounded-xl"><i class="fas fa-gamepad text-purple-600"></i></div></div>
                <h3 class="text-gray-500 text-xs font-black uppercase tracking-tighter">Partidas Jugadas</h3>
                <p class="text-4xl font-mono font-black italic">{{ $totalPartidas }}</p>
            </div>
            <div class="bg-gray-800 border border-gray-700 p-6 rounded-2xl shadow-xl border-l-4 border-l-red-600"><div class="flex justify-between items-start mb-4"><div class="p-3 bg-red-600/10 rounded-xl"><i class="fas fa-trophy text-red-600"></i></div></div>
                <h3 class="text-gray-500 text-xs font-black uppercase tracking-tighter">Récord Global</h3>
                <p class="text-4xl font-mono font-black italic text-red-600">{{ number_format($recordGlobal) }}</p>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            
            <div class="md:col-span-2 bg-gray-800 border border-gray-700 rounded-3xl p-8 shadow-2xl">
                
                @if($vistaActual === 'dashboard')
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-black uppercase italic">Nuevos Participantes</h3>
                        <button wire:click="irAVista('participantes')" class="text-xs text-red-500 hover:underline font-bold uppercase tracking-wider">Ver todos →</button>
                    </div>
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
                                <tr class="{{ $u->suspendido ? 'opacity-40 bg-red-950/10' : '' }}">
                                    <td class="py-4">
                                        <div class="font-bold flex items-center gap-2">
                                            {{ $u->name }}
                                            @if($u->suspendido) <span class="bg-red-600 text-white text-[8px] px-1.5 py-0.5 rounded uppercase font-black">Susp</span> @endif
                                        </div>
                                        <div class="text-[10px] text-gray-500">{{ $u->email }}</div>
                                    </td>
                                    <td class="py-4 text-gray-400">{{ $u->ciudad }}, {{ $u->estado }}</td>
                                    <td class="py-4 text-gray-400 text-xs">{{ $u->created_at ? $u->created_at->diffForHumans() : 'S/D' }}</td>
                                    <td class="py-4 text-right">
                                        <button wire:click="irAVista('partidas', {{ $u->id }})" class="text-red-600 hover:text-white transition px-2" title="Ver Partidas"><i class="fas fa-eye"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                @elseif($vistaActual === 'participantes')
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                        <h3 class="text-lg font-black uppercase italic text-white">Todos los Participantes</h3>
                        <input type="text" wire:model.live="search" placeholder="🔍 Buscar por nombre o correo..." 
                               class="bg-gray-900 border border-gray-700 rounded-xl px-4 py-2 text-xs text-gray-300 outline-none focus:border-red-600 w-full md:w-64 transition-colors">
                        <button wire:click="irAVista('dashboard')" class="bg-gray-700 hover:bg-gray-600 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition">← Volver</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="text-gray-500 border-b border-gray-700">
                                    <th class="pb-4 font-black uppercase italic text-xs">Usuario</th>
                                    <th class="pb-4 font-black uppercase italic text-xs">Ubicación</th>
                                    <th class="pb-4 font-black uppercase italic text-xs text-center">Acciones Auditoría</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700/50">
                                @forelse($todosParticipantes as $u)
                                <tr class="{{ $u->suspendido ? 'bg-red-950/20 text-gray-400' : '' }} hover:bg-gray-700/10">
                                    <td class="py-4">
                                        <div class="font-bold flex items-center gap-2 text-white">
                                            {{ $u->name }}
                                            @if($u->suspendido) <span class="bg-red-600 text-white text-[8px] px-1.5 py-0.5 rounded font-black uppercase">Suspendido</span> @endif
                                        </div>
                                        <div class="text-[10px] text-gray-500">{{ $u->email }}</div>
                                    </td>
                                    <td class="py-4 text-gray-400">{{ $u->ciudad }}, {{ $u->estado }}</td>
                                    <td class="py-4 flex justify-center gap-2">
                                        <button wire:click="irAVista('partidas', {{ $u->id }})" class="bg-purple-600/20 hover:bg-purple-600 text-purple-400 hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1">
                                            <i class="fas fa-gamepad"></i> Partidas
                                        </button>
                                        <button wire:click="toggleSuspension({{ $u->id }})" class="{{ $u->suspendido ? 'bg-green-600/20 hover:bg-green-600 text-green-400' : 'bg-red-600/20 hover:bg-red-600 text-red-400' }} hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                            <i class="fas {{ $u->suspendido ? 'fa-user-check' : 'fa-user-slash' }}"></i> {{ $u->suspendido ? 'Activar' : 'Suspender' }}
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="py-6 text-center text-gray-500 font-bold italic">No se encontraron participantes.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-4">{{ $todosParticipantes->links() }}</div>
                    </div>

                @elseif($vistaActual === 'partidas')
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-black uppercase italic text-purple-500">Historial de Partidas</h3>
                            <p class="text-xs text-gray-400 font-bold">Auditoría para: <span class="text-white font-black">{{ $usuarioSeleccionado->name }}</span> ({{ $usuarioSeleccionado->email }})</p>
                        </div>
                        <button wire:click="irAVista('participantes')" class="bg-gray-700 hover:bg-gray-600 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition">← Volver</button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="text-gray-500 border-b border-gray-700">
                                    <th class="pb-4 font-black uppercase italic text-xs">ID Partida</th>
                                    <th class="pb-4 font-black uppercase italic text-xs">Puntaje</th>
                                    <th class="pb-4 font-black uppercase italic text-xs">Fecha Jugada</th>
                                    <th class="pb-4 font-black uppercase italic text-xs text-center">Estado</th>
                                    <th class="pb-4"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700/50">
                                @forelse($partidasUsuario as $p)
                                <tr class="{{ $p->status === 'declinado' ? 'bg-red-950/10 opacity-50 line-through text-gray-500' : '' }}">
                                    <td class="py-4 font-mono">#{{ $p->id }}</td>
                                    <td class="py-4 text-lg font-black italic {{ $p->status === 'declinado' ? 'text-gray-500' : 'text-red-500' }}">{{ number_format($p->puntaje) }}</td>
                                    <td class="py-4 text-xs text-gray-400">{{ $p->created_at ? $p->created_at->format('d/m/Y H:i') : 'S/F' }}</td>
                                    <td class="py-4 text-center">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ $p->status === 'aprobado' ? 'bg-green-500/10 text-green-400' : 'bg-red-500/10 text-red-500' }}">
                                            {{ $p->status }}
                                        </span>
                                    </td>
                                    <td class="py-4 text-right">
                                        <button wire:click="declinarPartida({{ $p->id }})" class="{{ $p->status === 'declinado' ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-red-600 hover:bg-red-700 text-white' }} text-[10px] font-black uppercase px-2.5 py-1 rounded transition">
                                            {{ $p->status === 'declinado' ? 'Aprobar' : 'Invalidar' }}
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="py-6 text-center text-gray-500 font-bold italic">Este usuario no ha jugado ninguna partida aún.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="bg-black border border-gray-700 rounded-3xl p-8 flex flex-col gap-4 h-fit">
                <h3 class="text-lg font-black uppercase italic mb-2">Controles</h3>

                <button wire:click="irAVista('participantes')" class="w-full py-4 {{ $vistaActual === 'participantes' ? 'bg-blue-600 text-white' : 'bg-gray-800 hover:bg-blue-600 text-gray-300' }} rounded-xl text-xs font-black uppercase italic transition-all border border-gray-700">
                    <i class="fas fa-users-cog mr-2"></i> Ver Participantes
                </button>

                <button wire:click="exportarExcel"
                        wire:loading.attr="disabled"
                        class="w-full py-4 bg-gray-800 hover:bg-red-600 rounded-xl text-xs font-black uppercase italic transition-all border border-gray-700 flex justify-center items-center disabled:opacity-50">
                    
                    <span wire:loading.remove wire:target="exportarExcel">
                        <i class="fas fa-file-excel mr-2"></i> Exportar Participantes
                    </span>

                    <span wire:loading wire:target="exportarExcel" class="flex items-center">
                        <i class="fas fa-circle-notch animate-spin mr-2"></i> Generando archivo...
                    </span>
                </button>

                @if(!$mostrarAjustes)
                    <button wire:click="toggleBloqueAjustes" class="w-full py-4 bg-gray-800 hover:bg-blue-600 rounded-xl text-xs font-black uppercase italic transition-all border border-gray-700">
                        <i class="fas fa-cog mr-2"></i> Ajustes del Concurso
                    </button>
                @else
                    <div class="bg-gray-900 border border-gray-700 p-4 rounded-2xl space-y-4">
                        <div class="flex justify-between items-center border-b border-gray-800 pb-2">
                            <span class="text-xs font-black uppercase italic text-blue-500">Configuraciones</span>
                            <button wire:click="toggleBloqueAjustes" class="text-gray-500 hover:text-white text-xs"><i class="fas fa-times"></i></button>
                        </div>

                        <div class="flex items-center justify-between bg-gray-800 p-3 rounded-xl border border-gray-700">
                            <div><p class="text-xs font-bold text-white">Nuevos Registros</p></div>
                            <input type="checkbox" wire:model.live="registroActivo" wire:change="actualizarRegistro" class="w-4 h-4 accent-blue-600 cursor-pointer">
                        </div>

                        <div class="flex items-center justify-between bg-gray-800 p-3 rounded-xl border border-gray-700">
                            <div><p class="text-xs font-bold text-white">Botón de Jugar</p></div>
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
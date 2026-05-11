<div class="min-h-screen bg-gray-900 text-white p-6 md:p-12 font-sans">

    <!-- Header Admin -->
    <header class="max-w-7xl mx-auto mb-10 flex justify-between items-center border-b border-gray-800 pb-6">
        <div>
            <h1 class="text-3xl font-black italic uppercase">Admin<span class="text-red-600">Control</span></h1>
            <p class="text-gray-500 text-xs font-bold uppercase tracking-widest">Resumen General del Sistema</p>
        </div>

        <div class="flex gap-4">
            <a href="{{route('dashboard')}}" class="bg-red-600 hover:bg-red-700 text-white text-[10px] font-black uppercase px-4 py-2 rounded-lg transition-all">
                Regresar
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-gray-400 text-[10px] font-black uppercase px-4 py-2 rounded-lg border border-gray-700">
                    Salir
                </button>
            </form>
        </div>
    </header>

    <main class="max-w-7xl mx-auto">

        <h3 class="text-xl font-black uppercase italic mb-8 border-b border-gray-800 pb-4">
            <i class="fas fa-sliders-h mr-2 text-red-600"></i> Control de Fases
        </h3>

        @if (session()->has('settings_msg'))
            <div class="mb-6 p-3 bg-green-600/10 border border-green-600/20 text-green-500 text-[10px] font-black uppercase text-center rounded-lg">
                {{ session('settings_msg') }}
            </div>
        @endif

        <div class="space-y-8">
            <!-- Control de Registro -->
            <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-2xl border border-gray-700">
                <div>
                    <p class="text-white font-black uppercase italic text-sm">Registro de Usuarios</p>
                    <p class="text-gray-500 text-[10px] font-bold uppercase">Habilita o deshabilita el formulario de inscripción</p>
                </div>

                <button wire:click="toggleRegistro"
                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none {{ $registro_abierto ? 'bg-red-600' : 'bg-gray-600' }}">
                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $registro_abierto ? 'translate-x-6' : 'translate-x-1' }}"></span>
                </button>
            </div>

            <!-- Control de Juego -->
            <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-2xl border border-gray-700">
                <div>
                    <p class="text-white font-black uppercase italic text-sm">Acceso al Minijuego</p>
                    <p class="text-gray-500 text-[10px] font-bold uppercase">Bloquea el botón "¡A Jugar!" para todos</p>
                </div>

                <button wire:click="toggleJuego"
                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none {{ $juego_abierto ? 'bg-red-600' : 'bg-gray-600' }}">
                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $juego_abierto ? 'translate-x-6' : 'translate-x-1' }}"></span>
                </button>
            </div>
        </div>

        <div class="mt-10 pt-6 border-t border-gray-800">
            <div class="flex items-center gap-4 opacity-50">
                <i class="fas fa-info-circle text-red-600"></i>
                <p class="text-[9px] font-bold text-gray-400 uppercase leading-tight">
                    Los cambios se aplican en tiempo real. Si cierras una fase, los usuarios verán el botón bloqueado inmediatamente.
                </p>
            </div>
        </div>

    </main>
</div>


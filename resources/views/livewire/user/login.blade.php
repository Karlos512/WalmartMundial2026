<div class="min-h-screen bg-gray-900 flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden">

        <!-- Header con Identidad Visual -->
        <div class="bg-red-600 p-8 text-white text-center">
            <div class="inline-block bg-white p-3 rounded-full mb-4 shadow-lg">
                <i class="fas fa-user text-red-600 text-2xl"></i>
            </div>
            <h2 class="text-2xl font-black italic uppercase">¡Inicia Sesión!</h2>
            <p class="text-xs font-bold opacity-80">Ingresa para subir tus tickets y ver tus tiempos</p>
        </div>

        <form wire:submit.prevent="login" class="p-8 space-y-6">

            <!-- Correo -->
            <div class="relative">
                <label class="block text-[10px] font-black uppercase text-gray-400 mb-1">Correo Electrónico</label>
                <div class="flex items-center border-b-2 border-gray-100 focus-within:border-red-600 transition-colors">
                    <i class="fas fa-envelope text-gray-300 mr-3"></i>
                    <input type="email" wire:model="correo"
                           class="w-full py-2 outline-none text-gray-700 bg-transparent"
                           placeholder="ejemplo@correo.com">
                </div>
                @error('correo') <span class="text-red-600 text-[10px] font-bold uppercase mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Contraseña -->
            <div class="relative">
                <label class="block text-[10px] font-black uppercase text-gray-400 mb-1">Contraseña</label>
                <div class="flex items-center border-b-2 border-gray-100 focus-within:border-red-600 transition-colors">
                    <i class="fas fa-lock text-gray-300 mr-3"></i>
                    <input type="password" wire:model="password"
                           class="w-full py-2 outline-none text-gray-700 bg-transparent"
                           placeholder="••••••••">
                </div>
                @error('password') <span class="text-red-600 text-[10px] font-bold uppercase mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Opciones Extras -->
            <div class="flex items-center justify-between">
                <label class="flex items-center text-xs font-bold text-gray-500 cursor-pointer">
                    <input type="checkbox" wire:model="recordar" class="mr-2 accent-red-600">
                    Recordarme
                </label>
                {{-- <a href="#" class="text-xs font-bold text-red-600 hover:underline">¿Olvidaste tu clave?</a> --}}
            </div>

            <!-- Botón de Acción -->
            <div class="pt-4">
                <button type="submit"
                        wire:loading.attr="disabled"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-black italic uppercase py-4 rounded-xl shadow-lg shadow-red-900/20 transition-all transform hover:scale-[1.02] active:scale-95 flex justify-center items-center">
                    <span wire:loading.remove wire:target="login">Entrar al Reto</span>
                    <span wire:loading wire:target="login">
                        <i class="fas fa-circle-notch animate-spin"></i>
                    </span>
                </button>
            </div>

            <!-- Link a Registro -->
            <p class="text-center text-xs font-bold text-gray-400 mt-6">
                ¿Aún no tienes cuenta?
                <a href="{{ route('registro') }}" class="text-red-600 hover:underline uppercase italic">Regístrate aquí</a>
            </p>
        </form>
    </div>
</div>

<div class="min-h-screen bg-gray-900 flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden">
        <!-- Encabezado Estilo "Mamá Lucha" -->
        <div class="bg-red-600 p-6 text-white text-center">
            <h2 class="text-2xl font-black italic uppercase">Restablece tu contraseña</h2>
            {{-- <p class="text-sm opacity-90 font-bold">¡Regístrate para empezar a ganar!</p> --}}
        </div>

        <form wire:submit.prevent="enviarCorreo" class="p-8 space-y-4 text-gray-700">

            <!-- Contacto -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="text-[10px] font-black uppercase italic text-gray-500 tracking-widest">
                    Te enviaremos un correo para restablecer tu constraseña
                </label>
                <div>
                    <label class="block text-xs font-black uppercase text-gray-500">Correo Electrónico</label>
                    <input type="email" wire:model="email" class="w-full border-b-2 border-gray-200 focus:border-red-600 outline-none py-2">
                    @error('correo') <span class="text-red-600 text-[10px] uppercase font-bold">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Botón -->
            <div class="pt-4">
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black italic uppercase py-4 rounded-xl shadow-lg shadow-red-900/20 transition-all transform hover:scale-[1.01] active:scale-95">
                    ¡Restablecer Contraseña!
                </button>
            </div>
        </form>
    </div>
</div>

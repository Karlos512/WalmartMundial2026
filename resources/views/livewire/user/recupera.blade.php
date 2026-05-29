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
                <button type="submit" 
                        wire:loading.attr="disabled" 
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 disabled:opacity-50">
                    
                    <span wire:loading.remove>Siguiente Paso</span>
                    
                    <span wire:loading class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Enviando correo...
                    </span>

                </button>
            </div>
        </form>
    </div>
</div>

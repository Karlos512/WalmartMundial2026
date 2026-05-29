<div class="min-h-screen bg-gray-900 flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden">
        <!-- Encabezado Estilo "Mamá Lucha" -->
        <div class="bg-red-600 p-6 text-white text-center">
            <h2 class="text-2xl font-black italic uppercase">¡Regístrate para empezar a ganar!</h2>
            {{-- <p class="text-sm opacity-90 font-bold">¡Regístrate para empezar a ganar!</p> --}}
        </div>

        <form wire:submit.prevent="registrar" class="p-8 space-y-4 text-gray-700">

            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase italic text-gray-500 tracking-widest">
                    Tu Nickname para el Ranking
                </label>
                <div class="relative">
                    <input wire:model.blur="nickname" type="text"
                        placeholder="Ej: MasterGamer_99"
                        class="w-full bg-gray-800 border {{ $errors->has('nickname') ? 'border-red-600' : 'border-gray-700' }} rounded-xl px-4 py-3 text-sm focus:border-red-600 focus:ring-0 transition-all uppercase italic font-bold">

                    <!-- Icono de validación -->
                    <div class="absolute right-4 top-3.5">
                        @if($nickname && !$errors->has('nickname'))
                            <i class="fas fa-check text-green-500 text-xs"></i>
                        @elseif($errors->has('nickname'))
                            <i class="fas fa-times text-red-600 text-xs"></i>
                        @endif
                    </div>
                </div>
                @error('nickname')
                    <span class="text-[9px] text-red-600 font-black uppercase italic">{{ $message }}</span>
                @enderror
            </div>

            <!-- Nombre -->
            <div>
                <label class="block text-xs font-black uppercase text-gray-500">Nombre(s)</label>
                <input type="text" wire:model="nombre" class="w-full border-b-2 border-gray-200 focus:border-red-600 outline-none py-2 transition-colors">
                @error('nombre') <span class="text-red-600 text-[10px] uppercase font-bold">{{ $message }}</span> @enderror
            </div>

            <!-- Apellidos -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-black uppercase text-gray-500">Apellido Paterno</label>
                    <input type="text" wire:model="paterno" class="w-full border-b-2 border-gray-200 focus:border-red-600 outline-none py-2">
                    @error('paterno') <span class="text-red-600 text-[10px] uppercase font-bold">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-black uppercase text-gray-500">Apellido Materno</label>
                    <input type="text" wire:model="materno" class="w-full border-b-2 border-gray-200 focus:border-red-600 outline-none py-2">
                    @error('materno') <span class="text-red-600 text-[10px] uppercase font-bold">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Contacto -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-black uppercase text-gray-500">Correo Electrónico</label>
                    <input type="email" wire:model="correo" class="w-full border-b-2 border-gray-200 focus:border-red-600 outline-none py-2">
                    @error('correo') <span class="text-red-600 text-[10px] uppercase font-bold">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-black uppercase text-gray-500">Teléfono (10 dígitos)</label>
                    <input type="text" wire:model="telefono" class="w-full border-b-2 border-gray-200 focus:border-red-600 outline-none py-2">
                    @error('telefono') <span class="text-red-600 text-[10px] uppercase font-bold">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="pt-2">
                <label class="block text-xs font-black uppercase text-gray-500">Fecha de Nacimiento</label>
                <div class="flex items-center border-b-2 border-gray-200 focus-within:border-red-600 transition-colors">
                    <i class="fas fa-calendar-alt text-gray-300 mr-3"></i>
                    <input type="date" wire:model="fecha_nacimiento"
                           class="w-full py-2 outline-none text-gray-700 bg-transparent uppercase text-sm">
                </div>
                @error('fecha_nacimiento') <span class="text-red-600 text-[10px] uppercase font-bold">{{ $message }}</span> @enderror
            </div>

            <!-- CP y Estado -->
            <div class="grid grid-cols-2 gap-4 bg-gray-50  rounded-xl border border-gray-100">
                <div>
                    <label class="block text-xs font-black uppercase text-gray-500">Código Postal</label>
                    <input type="text" wire:model.live.debounce.500ms="cp" placeholder="00000" maxlength="5"
                           class="w-full bg-transparent border-b-2 border-gray-200 focus:border-red-600 outline-none py-2 font-mono text-lg">
                    @error('cp') <span class="text-red-600 text-[10px] font-bold uppercase">{{ $message }}</span> @enderror
                </div>
                <div wire:key="field-estado-{{ $cp }}">
                    <label class="block text-xs font-black uppercase text-gray-500">Estado</label>
                    <div class="relative">
                        <input type="text" wire:model="estado"
                               class="w-full bg-transparent border-b-2 border-gray-200 py-2 outline-none text-gray-400 font-bold uppercase cursor-not-allowed">
                        <div wire:loading wire:target="cp" class="absolute right-0 top-2">
                            <i class="fas fa-spinner animate-spin text-red-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 bg-gray-50  rounded-xl border border-gray-100">
                <div wire:key="field-ciudad-{{ $cp }}">
                    <label class="block text-xs font-black uppercase text-gray-500">Ciudad</label>
                    <div class="relative">
                        <input type="text" wire:model="ciudad"
                               class="w-full bg-transparent border-b-2 border-gray-200 py-2 outline-none text-gray-400 font-bold uppercase cursor-not-allowed">
                        <div wire:loading wire:target="cp" class="absolute right-0 top-2">
                            <i class="fas fa-spinner animate-spin text-red-600"></i>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-black uppercase text-gray-500">Colonia</label>
                    <select wire:model="colonia_seleccionada"
                            class="w-full bg-transparent border-b-2 border-gray-200 focus:border-red-600 outline-none py-2 text-sm text-gray-700 h-10">
                        <option value="">Selecciona tu colonia</option>
                        @foreach($listcolonias as $colonia)
                            <option value="{{ $colonia['nombre'] }}">{{ $colonia['nombre'] }}</option>
                        @endforeach
                    </select>
                    @error('colonia_seleccionada') <span class="text-red-600 text-[10px] font-bold">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Contraseña -->

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Campo Contraseña -->
                <div>
                    <label class="block text-xs font-black uppercase text-gray-500">Contraseña</label>
                    <div class="relative">
                        <input type="password"
                            wire:model="password"
                            class="w-full border-b-2 border-gray-200 focus:border-red-600 outline-none py-2 transition-all">
                        @error('password')
                            <span class="text-red-600 text-[10px] uppercase font-bold">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Campo Confirmar Contraseña -->
                <div>
                    <label class="block text-xs font-black uppercase text-gray-500">Confirmar Contraseña</label>
                    <div class="relative">
                        <input type="password"
                            wire:model="password_confirmation"
                            class="w-full border-b-2 border-gray-200 focus:border-red-600 outline-none py-2 transition-all">
                        @error('password_confirmation')
                            <span class="text-red-600 text-[10px] uppercase font-bold">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="space-y-3 pt-4">
                <div class="flex items-start">
                    <input wire:model="aceptar_terminos" type="checkbox" class="w-4 h-4 mt-1 text-red-600 accent-red-600">
                    <div class="ml-3 text-sm">
                        <label class="text-gray-700">
                            Acepto los <button type="button" wire:click="abrirTerminos" class="text-red-600 hover:underline font-bold italic">Términos y Condiciones</button>
                        </label>
                        @error('aceptar_terminos') <p class="text-red-600 text-[10px] font-bold uppercase mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-start">
                    <input wire:model="aceptar_privacidad" type="checkbox" class="w-4 h-4 mt-1 text-red-600 accent-red-600">
                    <div class="ml-3 text-sm">
                        <label class="text-gray-700">
                            He leído el <button type="button" wire:click="abrirPrivacidad" class="text-red-600 hover:underline font-bold italic">Aviso de Privacidad</button>
                        </label>
                        @error('aceptar_privacidad') <p class="text-red-600 text-[10px] font-bold uppercase mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            @if($mostrarModalTerminos)
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
                <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
                    <div class="bg-red-600 p-4 text-white flex justify-between items-center">
                        <h3 class="font-black uppercase italic">Términos y Condiciones</h3>
                        <button wire:click="cerrarTerminos" class="text-white hover:text-gray-200 text-2xl">&times;</button>
                    </div>
                    <div class="p-6 max-h-[60vh] overflow-y-auto text-gray-600 text-sm leading-relaxed">
                        <!-- AQUÍ VA TU TEXTO LEGAL -->
                        <p class="mb-4"><b>1. Participación:</b> El reto de Mamá Lucha está abierto a todos los clientes...</p>
                        <p class="mb-4"><b>2. Mecánica:</b> Para participar se requiere un ticket de compra mínima...</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                    </div>
                    <div class="p-4 border-t border-gray-100 flex justify-end">
                        <button wire:click="cerrarTerminos" class="bg-red-600 text-white px-6 py-2 rounded-lg font-bold uppercase text-xs hover:bg-red-700 transition">Entendido</button>
                    </div>
                </div>
            </div>
            @endif

            <!-- MODAL DE PRIVACIDAD (Repetir estructura cambiando variables) -->
            @if($mostrarModalPrivacidad)
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
                <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
                    <div class="bg-gray-800 p-4 text-white flex justify-between items-center">
                        <h3 class="font-black uppercase italic text-sm text-yellow-400">Aviso de Privacidad</h3>
                        <button wire:click="cerrarPrivacidad" class="text-white text-2xl">&times;</button>
                    </div>
                    <div class="p-6 max-h-[60vh] overflow-y-auto text-gray-600 text-sm">
                        <p>Sus datos personales están protegidos de acuerdo a la Ley Federal de Protección de Datos...</p>
                    </div>
                    <div class="p-4 border-t border-gray-100 flex justify-end">
                        <button wire:click="cerrarPrivacidad" class="bg-gray-800 text-white px-6 py-2 rounded-lg font-bold uppercase text-xs">Cerrar</button>
                    </div>
                </div>
            </div>
            @endif

            <!-- Botón -->
            <div class="pt-4">
                <button type="submit" 
                    wire:loading.attr="disabled" 
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 disabled:opacity-50">
                
                <span wire:loading.remove>Registrarse</span>
                
                <span wire:loading class="flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Procesando registro...
                </span>
            </button>
            </div>
        </form>
    </div>
</div>

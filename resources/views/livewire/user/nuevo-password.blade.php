<div class="h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4 text-center text-gray-800 uppercase">Nueva Contraseña</h2>
        <p class="text-sm text-gray-500 mb-6 text-center">Ingresa tu nueva contraseña para actualizar tu cuenta de competidor.</p>

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="actualizarContrasena">
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nueva Contraseña</label>
                <input type="password" wire:model="password" required 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-red-500 @error('password') border-red-500 @enderror">
                @error('password') 
                    <span class="text-red-500 text-xs font-semibold mt-1 block">{{ $message }}</span> 
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Confirmar Nueva Contraseña</label>
                <input type="password" wire:model="password_confirmation" required 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-red-500">
            </div>

            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                Actualizar Contraseña
            </button>
        </form>
    </div>
</div>
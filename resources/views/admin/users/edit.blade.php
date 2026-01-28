<x-admin-layout>
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-white">Editar Usuario</h1>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6 border border-gray-200 dark:border-slate-700">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Nombre</label>
                    <input type="text" name="name" id="name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-slate-600 rounded-md dark:bg-slate-900 dark:text-white" value="{{ old('name', $user->name) }}" required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Email</label>
                    <input type="email" name="email" id="email" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-slate-600 rounded-md dark:bg-slate-900 dark:text-white" value="{{ old('email', $user->email) }}" required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Nueva Contraseña (Opcional)</label>
                    <input type="password" name="password" id="password" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-slate-600 rounded-md dark:bg-slate-900 dark:text-white">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Confirmar Nueva Contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-slate-600 rounded-md dark:bg-slate-900 dark:text-white">
                </div>

                <div class="col-span-2">
                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Rol</label>
                    <select name="role" id="role" class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:text-white" {{ $user->hasRole('super-admin') ? 'disabled' : '' }}>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ (old('role') == $role->name || $user->hasRole($role->name)) ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                    @if($user->hasRole('super-admin'))
                        <input type="hidden" name="role" value="super-admin">
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">El rol de Super Admin no se puede cambiar.</p>
                    @endif
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('admin.users.index') }}" class="bg-gray-200 hover:bg-gray-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-800 dark:text-white font-bold py-2 px-4 rounded mr-2">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>

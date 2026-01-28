<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-white">Usuarios</h1>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Nuevo Usuario
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-lg shadow overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-semibold text-gray-600 dark:text-slate-300 uppercase tracking-wider">
                        Nombre
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-semibold text-gray-600 dark:text-slate-300 uppercase tracking-wider">
                        Email
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-semibold text-gray-600 dark:text-slate-300 uppercase tracking-wider">
                        Rol
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-semibold text-gray-600 dark:text-slate-300 uppercase tracking-wider">
                        Fecha Creación
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-semibold text-gray-600 dark:text-slate-300 uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm">
                            <p class="text-gray-900 dark:text-white whitespace-no-wrap">{{ $user->name }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm">
                            <p class="text-gray-900 dark:text-white whitespace-no-wrap">{{ $user->email }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm">
                            @foreach($user->roles as $role)
                                <span class="relative inline-block px-3 py-1 font-semibold leading-tight text-blue-900 dark:text-blue-100">
                                    <span aria-hidden class="absolute inset-0 bg-blue-200 dark:bg-blue-900 opacity-50 rounded-full"></span>
                                    <span class="relative">{{ ucfirst($role->name) }}</span>
                                </span>
                            @endforeach
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm">
                            <p class="text-gray-900 dark:text-white whitespace-no-wrap">{{ $user->created_at->format('d/m/Y') }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 mr-4">Editar</a>
                            @if(!$user->hasRole('super-admin'))
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">Eliminar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-5 py-5 bg-white dark:bg-slate-800 border-t border-gray-200 dark:border-slate-700 flex flex-col xs:flex-row items-center xs:justify-between">
            {{ $users->links() }}
        </div>
    </div>
</x-admin-layout>

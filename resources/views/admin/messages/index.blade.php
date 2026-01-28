<x-admin-layout>
    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Mensajes de Contacto</h2>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-slate-800 shadow-md rounded-lg overflow-hidden border border-gray-200 dark:border-slate-700">
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-semibold text-gray-600 dark:text-slate-300 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-semibold text-gray-600 dark:text-slate-300 uppercase tracking-wider">
                                Fecha
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-semibold text-gray-600 dark:text-slate-300 uppercase tracking-wider">
                                Nombre
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-semibold text-gray-600 dark:text-slate-300 uppercase tracking-wider">
                                Email
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-semibold text-gray-600 dark:text-slate-300 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $message)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm">
                                @if($message->is_read)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-slate-700 dark:text-slate-300">
                                        Leído
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                        Nuevo
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm text-gray-900 dark:text-white">
                                {{ $message->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm font-medium text-gray-900 dark:text-white">
                                {{ $message->name }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm text-gray-900 dark:text-slate-300">
                                {{ $message->email }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('admin.messages.show', $message) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">Ver</a>
                                    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este mensaje?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm text-center text-gray-500 dark:text-slate-400">
                                No hay mensajes de contacto.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-5 bg-white dark:bg-slate-800 border-t border-gray-200 dark:border-slate-700">
                {{ $messages->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
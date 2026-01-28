<x-admin-layout>
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-white">Comentarios</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800 rounded-lg shadow overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-semibold text-gray-600 dark:text-slate-300 uppercase tracking-wider">
                        Usuario / Autor
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-semibold text-gray-600 dark:text-slate-300 uppercase tracking-wider">
                        Comentario
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-semibold text-gray-600 dark:text-slate-300 uppercase tracking-wider">
                        En Noticia
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-semibold text-gray-600 dark:text-slate-300 uppercase tracking-wider">
                        Estado
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-semibold text-gray-600 dark:text-slate-300 uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($comments as $comment)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm">
                            <div class="flex items-center">
                                <div class="ml-3">
                                    <p class="text-gray-900 dark:text-white whitespace-no-wrap font-bold">
                                        {{ $comment->name }}
                                    </p>
                                    <p class="text-gray-600 dark:text-slate-300 whitespace-no-wrap text-xs">
                                        {{ $comment->email }}
                                    </p>
                                    <p class="text-gray-500 dark:text-slate-400 whitespace-no-wrap text-xs mt-1">
                                        {{ $comment->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm">
                            <p class="text-gray-900 dark:text-white whitespace-pre-wrap max-w-xs">{{ Str::limit($comment->content, 100) }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm">
                            <a href="{{ route('news.show', $comment->post) }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                {{ Str::limit($comment->post->title, 30) }}
                            </a>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm">
                            <span class="relative inline-block px-3 py-1 font-semibold leading-tight {{ $comment->is_approved ? 'text-green-900 dark:text-green-100' : 'text-red-900 dark:text-red-100' }}">
                                <span aria-hidden class="absolute inset-0 {{ $comment->is_approved ? 'bg-green-200 dark:bg-green-900' : 'bg-red-200 dark:bg-red-900' }} opacity-50 rounded-full"></span>
                                <span class="relative">{{ $comment->is_approved ? 'Aprobado' : 'Rechazado' }}</span>
                            </span>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm">
                            <div class="flex items-center space-x-2">
                                <form action="{{ route('admin.comments.toggle-approval', $comment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-xs font-bold py-1 px-2 rounded {{ $comment->is_approved ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200 dark:bg-yellow-900 dark:text-yellow-100 dark:hover:bg-yellow-800' : 'bg-green-100 text-green-800 hover:bg-green-200 dark:bg-green-900 dark:text-green-100 dark:hover:bg-green-800' }}">
                                        {{ $comment->is_approved ? 'Rechazar' : 'Aprobar' }}
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este comentario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 font-bold">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm text-center text-gray-500 dark:text-gray-400">
                            No hay comentarios registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-5 bg-white dark:bg-slate-800 border-t border-gray-200 dark:border-slate-700 flex flex-col xs:flex-row items-center xs:justify-between">
            {{ $comments->links() }}
        </div>
    </div>
</x-admin-layout>
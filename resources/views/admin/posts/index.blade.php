<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-white">Noticias</h1>
        <div class="flex gap-4">
            <form action="{{ route('admin.posts.index') }}" method="GET" class="flex">
                <input type="text" name="search" placeholder="Buscar noticias..." value="{{ request('search') }}" 
                    class="rounded-l border-gray-300 dark:border-gray-700 dark:bg-slate-900 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                <button type="submit" class="bg-gray-200 dark:bg-slate-700 hover:bg-gray-300 dark:hover:bg-slate-600 px-4 py-2 rounded-r transition-colors">
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
            <a href="{{ route('admin.posts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors flex items-center">
                Nueva Noticia
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-lg shadow overflow-hidden transition-colors">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-semibold text-gray-600 dark:text-slate-300 uppercase tracking-wider">
                            Título
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-semibold text-gray-600 dark:text-slate-300 uppercase tracking-wider">
                            Autor
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-semibold text-gray-600 dark:text-slate-300 uppercase tracking-wider">
                            Categoría
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-semibold text-gray-600 dark:text-slate-300 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-semibold text-gray-600 dark:text-slate-300 uppercase tracking-wider">
                            Fecha
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-700 text-left text-xs font-semibold text-gray-600 dark:text-slate-300 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm">
                                <div class="flex items-center">
                                    <div class="ml-3">
                                        <p class="text-gray-900 dark:text-slate-100 whitespace-no-wrap">
                                            {{ $post->title }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm">
                                <p class="text-gray-900 dark:text-slate-100 whitespace-no-wrap">{{ $post->author->name }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm">
                                <p class="text-gray-900 dark:text-slate-100 whitespace-no-wrap">{{ $post->category->name }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm">
                                <span class="relative inline-block px-3 py-1 font-semibold leading-tight {{ $post->status === 'published' ? 'text-green-900 dark:text-green-100' : 'text-orange-900 dark:text-orange-100' }}">
                                    <span aria-hidden class="absolute inset-0 {{ $post->status === 'published' ? 'bg-green-200 dark:bg-green-900' : 'bg-orange-200 dark:bg-orange-900' }} opacity-50 rounded-full"></span>
                                    <span class="relative">{{ ucfirst($post->status) }}</span>
                                </span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm">
                                <p class="text-gray-900 dark:text-slate-100 whitespace-no-wrap">{{ $post->created_at->format('d/m/Y') }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 mr-4">Editar</a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-5 bg-white dark:bg-slate-800 border-t border-gray-200 dark:border-slate-700 flex flex-col xs:flex-row items-center xs:justify-between">
            {{ $posts->links() }}
        </div>
    </div>
</x-admin-layout>
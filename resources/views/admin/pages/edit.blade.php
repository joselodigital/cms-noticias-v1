<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Editar Página: {{ $page->title }}</h1>
        <a href="{{ route('admin.pages.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Volver
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
        <form action="{{ route('admin.pages.update', $page) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Título</label>
                <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md bg-white dark:bg-slate-900 border-gray-300 dark:border-slate-600 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('title', $page->title) }}" required>
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Slug (URL)</label>
                <input type="text" value="{{ $page->slug }}" class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-slate-900 border-gray-300 dark:border-slate-600 text-gray-500 dark:text-slate-500 shadow-sm sm:text-sm cursor-not-allowed" disabled>
                <p class="mt-1 text-xs text-gray-500 dark:text-slate-500">El slug se genera automáticamente y no se puede cambiar para preservar el SEO.</p>
            </div>

            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Contenido</label>
                <textarea name="content" id="content" rows="10" class="mt-1 block w-full rounded-md bg-white dark:bg-slate-900 border-gray-300 dark:border-slate-600 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('content', $page->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 flex items-center">
                <input type="checkbox" name="is_active" id="is_active" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-slate-600 rounded bg-white dark:bg-slate-900" {{ old('is_active', $page->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="ml-2 block text-sm text-gray-700 dark:text-slate-400">
                    Activo (visible públicamente)
                </label>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Actualizar Página
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#content'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo']
            })
            .catch(error => {
                console.error(error);
            });
    </script>
</x-admin-layout>

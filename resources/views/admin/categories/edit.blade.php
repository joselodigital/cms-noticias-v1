<x-admin-layout>
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-white">Editar Categoría</h1>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6 border border-gray-200 dark:border-slate-700">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Nombre</label>
                    <input type="text" name="name" id="name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-slate-600 rounded-md dark:bg-slate-900 dark:text-white" value="{{ old('name', $category->name) }}" required>
                </div>

                <div class="col-span-2">
                    <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Slug</label>
                    <input type="text" name="slug" id="slug" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-slate-600 rounded-md dark:bg-slate-900 dark:text-white" value="{{ old('slug', $category->slug) }}" required>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-200 hover:bg-gray-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-800 dark:text-white font-bold py-2 px-4 rounded mr-2">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
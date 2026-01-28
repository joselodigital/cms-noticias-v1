<x-admin-layout>
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Añadir Enlace Superior</h1>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-slate-700">
        <form action="{{ route('admin.top_bar_links.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Label -->
                <div>
                    <x-input-label for="label" :value="__('Etiqueta')" />
                    <x-text-input id="label" class="block mt-1 w-full" type="text" name="label" :value="old('label')" required autofocus />
                    <x-input-error :messages="$errors->get('label')" class="mt-2" />
                </div>

                <!-- URL -->
                <div>
                    <x-input-label for="url" :value="__('URL')" />
                    <x-text-input id="url" class="block mt-1 w-full" type="text" name="url" :value="old('url')" required />
                    <x-input-error :messages="$errors->get('url')" class="mt-2" />
                </div>

                <!-- Order -->
                <div>
                    <x-input-label for="order" :value="__('Orden')" />
                    <x-text-input id="order" class="block mt-1 w-full" type="number" name="order" :value="old('order', 0)" />
                    <x-input-error :messages="$errors->get('order')" class="mt-2" />
                </div>

                <!-- Active -->
                <div class="flex items-center mt-8">
                    <label for="is_active" class="inline-flex items-center">
                        <input id="is_active" type="checkbox" class="rounded dark:bg-slate-900 border-gray-300 dark:border-slate-700 text-blue-600 shadow-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:focus:ring-offset-slate-800" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-600 dark:text-slate-400">{{ __('Activo') }}</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-end">
                <a href="{{ route('admin.top_bar_links.index') }}" class="text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white mr-4">Cancelar</a>
                <x-primary-button>
                    {{ __('Guardar Enlace') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-admin-layout>
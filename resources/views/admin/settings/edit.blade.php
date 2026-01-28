<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700">
                    <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Configuración del Sitio</h2>

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nombre del Sitio -->
                        <div class="mb-4">
                            <label for="site_name" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Nombre del Sitio</label>
                            <input type="text" name="site_name" id="site_name" value="{{ old('site_name', $settings->site_name) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-slate-900 dark:text-white">
                            @error('site_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Descripción del Sitio -->
                        <div class="mb-4">
                            <label for="site_description" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Descripción del Sitio</label>
                            <input type="text" name="site_description" id="site_description" value="{{ old('site_description', $settings->site_description) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-slate-900 dark:text-white">
                            @error('site_description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sobre Nosotros (Footer) -->
                        <div class="mb-4">
                            <label for="footer_about_us" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Sobre Nosotros (Footer)</label>
                            <textarea name="footer_about_us" id="footer_about_us" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-slate-900 dark:text-white">{{ old('footer_about_us', $settings->footer_about_us) }}</textarea>
                            <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Este texto aparecerá en la sección "Sobre Nosotros" del pie de página.</p>
                            @error('footer_about_us')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Favicon -->
                        <div class="mb-4">
                            <label for="favicon" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Favicon</label>
                            @if($settings->favicon_path)
                                <div class="mt-2 mb-2">
                                    <img src="{{ asset('storage/' . $settings->favicon_path) }}" alt="Favicon" class="h-8 w-8 object-contain bg-gray-200 dark:bg-slate-600 p-1 rounded">
                                </div>
                            @endif
                            <input type="file" name="favicon" id="favicon" class="mt-1 block w-full text-sm text-gray-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-200">
                            <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Recomendado: ICO, PNG o SVG (32x32 o 64x64).</p>
                            @error('favicon')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Guardar Cambios') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

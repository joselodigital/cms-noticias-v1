<x-admin-layout>
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Editar Red Social</h1>
        <a href="{{ route('admin.social_links.index') }}" class="text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white transition duration-150 ease-in-out">
            &larr; Volver
        </a>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-slate-800 max-w-2xl">
        <form action="{{ route('admin.social_links.update', $socialLink->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Nombre para mostrar</label>
                <input type="text" name="name" id="name" class="w-full rounded-md bg-white dark:bg-slate-950 border-gray-300 dark:border-slate-700 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('name', $socialLink->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="platform" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Plataforma</label>
                <select name="platform" id="platform" class="w-full rounded-md bg-white dark:bg-slate-950 border-gray-300 dark:border-slate-700 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                    <option value="facebook" {{ old('platform', $socialLink->platform) == 'facebook' ? 'selected' : '' }}>Facebook</option>
                    <option value="twitter" {{ old('platform', $socialLink->platform) == 'twitter' ? 'selected' : '' }}>Twitter / X</option>
                    <option value="instagram" {{ old('platform', $socialLink->platform) == 'instagram' ? 'selected' : '' }}>Instagram</option>
                    <option value="linkedin" {{ old('platform', $socialLink->platform) == 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                    <option value="youtube" {{ old('platform', $socialLink->platform) == 'youtube' ? 'selected' : '' }}>YouTube</option>
                    <option value="tiktok" {{ old('platform', $socialLink->platform) == 'tiktok' ? 'selected' : '' }}>TikTok</option>
                    <option value="github" {{ old('platform', $socialLink->platform) == 'github' ? 'selected' : '' }}>GitHub</option>
                </select>
                @error('platform')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="url" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">URL del Perfil</label>
                <input type="url" name="url" id="url" class="w-full rounded-md bg-white dark:bg-slate-900 border-gray-300 dark:border-slate-600 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('url', $socialLink->url) }}" required>
                @error('url')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">
                    Actualizar Red Social
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
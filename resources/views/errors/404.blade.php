<x-public-layout>
    <div class="min-h-[70vh] flex flex-col items-center justify-center text-center px-4">
        <h1 class="text-9xl font-bold text-gray-200 dark:text-gray-700">404</h1>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-4">Página no encontrada</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-2 max-w-md mx-auto">
            Lo sentimos, la página que estás buscando no existe o ha sido movida.
        </p>
        <a href="{{ route('home') }}" class="mt-8 inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition duration-150 ease-in-out">
            Volver al Inicio
        </a>
    </div>
</x-public-layout>

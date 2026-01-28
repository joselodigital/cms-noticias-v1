@props(['disabled' => false])

<input @disabled($disabled)<input {{ $attributes->merge(['class' => 'border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) }}>

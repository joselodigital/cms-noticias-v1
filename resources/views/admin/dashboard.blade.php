<x-admin-layout>
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Dashboard</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Resumen rápido de la actividad de tu medio.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="text-right">
                <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ auth()->user()->name }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 capitalize">
                    {{ implode(', ', auth()->user()->getRoleNames()->toArray()) }}
                </p>
            </div>
            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center text-white font-semibold text-sm shadow-md">
                {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1 -->
        <div class="bg-white/95 dark:bg-slate-800/95 backdrop-blur rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-500 dark:text-blue-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 dark:text-slate-400">Total Noticias</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalPosts }}</p>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white/95 dark:bg-slate-800/95 backdrop-blur rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/30 text-green-500 dark:text-green-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 dark:text-slate-400">Publicadas</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $publishedPosts }}</p>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white/95 dark:bg-slate-800/95 backdrop-blur rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-500 dark:text-yellow-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 dark:text-slate-400">Borradores</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $draftPosts }}</p>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white/95 dark:bg-slate-800/95 backdrop-blur rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-500 dark:text-purple-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 dark:text-slate-400">Usuarios</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white/95 dark:bg-slate-800/95 backdrop-blur rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
        <h2 class="text-xl font-semibold mb-4 text-slate-900 dark:text-white">Actividad de Publicaciones</h2>
        <canvas id="postsChart" height="100"
            data-labels="{{ json_encode($labels) }}" 
            data-values="{{ json_encode($data) }}">
        </canvas>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('postsChart');
            const ctx = canvas.getContext('2d');
            
            // Function to get colors based on theme
            const getChartColors = () => {
                const isDark = document.documentElement.classList.contains('dark');
                return {
                    text: isDark ? '#94a3b8' : '#64748b', // slate-400 : slate-500
                    grid: isDark ? '#334155' : '#e2e8f0'  // slate-700 : slate-200
                };
            };

            const colors = getChartColors();
            
            const chartLabels = JSON.parse(canvas.dataset.labels);
            const chartData = JSON.parse(canvas.dataset.values);

            let postsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Nuevas Noticias',
                        data: chartData,
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            labels: {
                                color: colors.text
                            }
                        }
                    },
                    scales: {
                        y: {
                            grid: {
                                color: colors.grid
                            },
                            ticks: {
                                color: colors.text
                            }
                        },
                        x: {
                            grid: {
                                color: colors.grid
                            },
                            ticks: {
                                color: colors.text
                            }
                        }
                    }
                }
            });

            // Observer to update chart on theme change
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        const newColors = getChartColors();
                        postsChart.options.plugins.legend.labels.color = newColors.text;
                        postsChart.options.scales.y.grid.color = newColors.grid;
                        postsChart.options.scales.y.ticks.color = newColors.text;
                        postsChart.options.scales.x.grid.color = newColors.grid;
                        postsChart.options.scales.x.ticks.color = newColors.text;
                        postsChart.update();
                    }
                });
            });

            observer.observe(document.documentElement, {
                attributes: true
            });
        });
    </script>
</x-admin-layout>
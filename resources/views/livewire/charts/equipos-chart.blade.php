<div class="bg-white dark:bg-neutral-800 rounded-xl shadow p-4">
    <h2 class="text-sm font-semibold mb-3">
        Equipos por estado
    </h2>

    <div wire:ignore class="relative h-64">
        <canvas id="chartEquipos"></canvas>
    </div>
</div>

@push('scripts')
    <script>
        let chartEquipos;

        document.addEventListener('livewire:navigated', () => {
            const canvas = document.getElementById('chartEquipos');
            if (!canvas) return;

            chartEquipos?.destroy();

            chartEquipos = new Chart(canvas, {
                type: 'doughnut',
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [{
                        data: @json($chartData['values']),
                        backgroundColor: [
                            '#72E9C5', // Equipos Disponibles (verde)
                            '#FFD15C', // Equipos Asignados (Amarrillo)
                            '#FF587A', // Equipos Hurtados (Rojo)
                        ],
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                }
            });
        });
    </script>
@endpush

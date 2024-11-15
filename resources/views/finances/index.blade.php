@extends('layouts.app')

@section('content')
    <div style="display: flex; align-items: center;">
        <h1 style="margin-right: 20px;">Фінансові показники</h1>
        <a href="{{ route('home') }}" class="btn btn-secondary">Повернутись на домашню сторінку</a>
    </div>
    
    <form method="GET" action="{{ route('finance.index') }}" id="financeForm">
        <div class="mb-3">
            <label for="period" class="form-label">Оберіть період</label>
            <select name="period" id="period" class="form-control">
                <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>За місяць</option>
                <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>За тиждень</option>
                <option value="custom" {{ request('period') == 'custom' ? 'selected' : '' }}>Вибраний період</option>
            </select>
        </div>

        <div id="customDateRange" style="display: {{ request('period') == 'custom' ? 'block' : 'none' }};">
            <div class="mb-3">
                <label for="start_date" class="form-label">Початкова дата</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $startDate ? $startDate->toDateString() : '') }}">
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">Кінцева дата</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $endDate ? $endDate->toDateString() : '') }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Показати</button>
    </form>

    <h2>Доходи: {{ number_format($income, 2) }} грн</h2>
    <h2>Витрати: {{ number_format($expenses, 2) }} грн</h2>
    <h2>Чистий прибуток: {{ number_format($netProfit, 2) }} грн</h2>

    <div style="display: flex; justify-content: flex-start; width: 100%; margin: auto;">
        <div class="chart-container" style="flex: 1; padding: 10px;">
            <canvas id="financeBarChart" width="950" height="350"></canvas>
        </div>
        <div class="chart-container" style="flex: 1; padding: 10px;">
            <canvas id="financeDoughnutChart" width="400" height="200"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.getElementById('period').addEventListener('change', function () {
            document.getElementById('customDateRange').style.display = this.value === 'custom' ? 'block' : 'none';
        });

        document.getElementById('financeForm').addEventListener('submit', function (e) {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
                e.preventDefault();
                alert('Кінцева дата повинна бути пізніше початкової дати.');
            }
        });

        // Стовпчиковий графік
        const barCtx = document.getElementById('financeBarChart').getContext('2d');
        const financeBarChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Доходи', 'Витрати', 'Чистий прибуток'],
                datasets: [{
                    label: 'Фінансові показники',
                    data: [{{ $income }}, {{ $expenses }}, {{ $netProfit }}],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(255, 206, 86, 0.6)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Сума (грн)'
                        }
                    },
                },
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Графік',
                        font: {
                            size: 18,
                        }
                    }
                }
            }
        });

        // Кругова діаграма
        const doughnutCtx = document.getElementById('financeDoughnutChart').getContext('2d');
        const financeDoughnutChart = new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Доходи', 'Витрати', 'Чистий прибуток'],
                datasets: [{
                    label: 'Фінансові показники',
                    data: [{{ $income }}, {{ $expenses }}, {{ $netProfit }}],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(255, 206, 86, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 255, 255, 1)',
                        'rgba(255, 255, 255, 1)',
                        'rgba(255, 255, 255, 1)'
                    ],
                    borderWidth: 2,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Діаграма',
                        font: {
                            size: 18,
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw.toFixed(2) + ' грн';
                            }
                        }
                    }
                }
            }
        });

    </script>
@endsection

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Фінансовий звіт</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 10px; }
        h1 { text-align: center; font-size: 18px; margin-bottom: 5px; }
        p { font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <h1>Фінансовий звіт</h1>
    <p>Період: з {{ $startDate->format('d.m.Y') }} по {{ $endDate->format('d.m.Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Тип</th>
                <th>Деталі</th>
                <th>Сума, грн</th>
            </tr>
        </thead>
        <tbody>
            <!-- Доходи -->
            @foreach ($orders as $index => $order)
                <tr>
                    @if ($index === 0)
                        <td rowspan="{{ count($orders) }}">Доходи</td>
                    @endif
                    <td>Замовлення #{{ $order->id }} ({{ $order->loading_place }} - {{ $order->unloading_place }})</td>
                    <td>{{ number_format($order->transport_cost, 2) }} грн</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="2">Загальний дохід</td>
                <td>{{ number_format($income, 2) }} грн</td>
            </tr>

            <!-- Витрати -->
            @foreach ($expenses as $index => $expense)
                <tr>
                    @if ($index === 0)
                        <td rowspan="{{ count($expenses) * 2 }}">Витрати</td>
                    @endif
                    <td>Витрати на паливо ({{ \Carbon\Carbon::parse($expense->date)->format('d.m.Y') }})</td>
                    <td>{{ number_format($expense->total_fuel_cost, 2) }} грн</td>
                </tr>
                <tr>
                    <td>Амортизаційні витрати ({{ \Carbon\Carbon::parse($expense->date)->format('d.m.Y') }})</td>
                    <td>{{ number_format($expense->total_amortization_cost, 2) }} грн</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="2">Загальні витрати</td>
                <td>{{ number_format($totalExpenses, 2) }} грн</td>
            </tr>

            <!-- Чистий дохід -->
            <tr class="total">
                <td colspan="2">Чистий дохід</td>
                <td>{{ number_format($netProfit, 2) }} грн</td>
            </tr>
        </tbody>
    </table>
</body>
</html>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Звіт за доходами</title>
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
    <h1>Звіт за доходами</h1>
    <p>Період: з {{ $startDate->format('d.m.Y') }} по {{ $endDate->format('d.m.Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Дата</th>
                <th>Клієнт</th>
                <th>Маршрут</th>
                <th>Сума, грн</th>
            </tr>
        </thead>
        <tbody>
            @foreach($incomeData as $income)
                <tr>
                    <td>{{ $income->created_at->format('d.m.Y') }}</td>
                    <td>{{ $income->client }}</td>
                    <td>{{ $income->loading_place }} - {{ $income->unloading_place }}</td>
                    <td>{{ number_format($income->transport_cost, 2) }} грн</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" class="total">Загальна сума:</td>
                <td class="total">{{ number_format($incomeData->sum('transport_cost'), 2) }} грн</td>
            </tr>
        </tbody>
    </table>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Звіт за витратами</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 10px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black; /* Чорні лінії в таблиці */
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Звіт за витратами</h1>
    <p>Період: {{ $startDate->format('d.m.Y') }} - {{ $endDate->format('d.m.Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Дата</th>
                <th>Витрати на паливо</th>
                <th>Амортизація</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenseData as $expense)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($expense->date)->format('d.m.Y') }}</td>
                    <td>{{ $expense->total_fuel_cost }}</td>
                    <td>{{ $expense->total_amortization_cost }}</td>
                    </tr>
            @endforeach
            <tr>
                <td class="total">Загальні витрати:</td>
                <td class="total">{{ number_format($expenseData->sum('total_fuel_cost'), 2) }} грн</td>
                <td class="total">{{ number_format($expenseData->sum('total_amortization_cost'), 2) }} грн</td>
            </tr>
            <tr>
                <td class="total">Загальна сума витрат:</td>
                <td class="total" colspan="2">{{ number_format($expenseData->sum('total_fuel_cost') + $expenseData->sum('total_amortization_cost'), 2) }} грн</td>
            </tr>
        </tbody>
    </table>
</body>
</html>

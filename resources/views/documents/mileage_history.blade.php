<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Історія пробігів</title>
    <style>
         body { font-family: DejaVu Sans, sans-serif; margin: 10px; }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black; /* Чорні лінії таблиці */
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<h1>Історія пробігів {{ $truck->make }} {{ $truck->brand }} {{ $truck->model }} ({{ $truck->license_plate }})</h1>
<table>
    <table>
        <tr>
            <th>Дата</th>
            <th>Пробіг (км)</th>
            <th>Вартість палива (за 100 км)</th>
            <th>Вартість амортизації (за 100 км)</th>
            <th>Загальна вартість палива</th>
            <th>Загальна вартість амортизації</th>
        </tr>
        @foreach($mileageHistory as $record)
            <tr>
            <td>{{ \Carbon\Carbon::parse($record->date)->format('d.m.Y') }}</td>

                <td>{{ $record->mileage }} км</td>
                <td>{{ $record->fuel_cost_per_100km }} грн</td>
                <td>{{ $record->amortization_cost_per_100km }} грн</td>
                <td>{{ $record->total_fuel_cost }} грн</td>
                <td>{{ $record->total_amortization_cost }} грн</td>
            </tr>
        @endforeach
    </table>
</body>
</html>

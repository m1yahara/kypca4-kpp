<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Усі замовлення</title>
    <style>
       body {
        font-family: DejaVu Sans, sans-serif;
            font-size: 10px; /* зменшення розміру тексту */
            margin: 10px; /* зменшення загальних відступів */
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px; /* загальний розмір тексту для таблиці */
        }
        th, td {
            border: 1px solid black;
            padding: 4px; /* зменшення відступів в осередках */
            text-align: left;
            vertical-align: top; /* вирівнювання тексту по верхньому краю */
            word-wrap: break-word; /* перенесення слів */
        }
        th {
            background-color: #f2f2f2;
        } 
    </style>
</head>
<body>
    <h1>Усі замовлення</h1>
    <p>Період: {{ \Carbon\Carbon::parse($startDate)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d.m.Y') }}</p>

    <table>
        <tr>
            <th>Номер замовлення</th>
            <th>Клієнт</th>
            <th>Телефон</th>
            <th>Місце завантаження</th>
            <th>Місце розвантаження</th>
            <th>Дата завантаження</th>
            <th>Дата розвантаження</th>
            <th>Тип вантажу</th>
            <th>Кількість зерна (т)</th>
            <th>Ціна за тонну (грн)</th>
            <th>Транспортні витрати (грн)</th>
            <th>Примітки</th>
        </tr>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->client }}</td>
                <td>{{ $order->phone }}</td>
                <td>{{ $order->loading_place }}</td>
                <td>{{ $order->unloading_place }}</td>
                <td>{{ \Carbon\Carbon::parse($order->loading_date)->format('d.m.Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($order->unloading_date)->format('d.m.Y') }}</td>
                <td>{{ $order->cargo_type }}</td>
                <td>{{ $order->grain_quantity }} т</td>
                <td>{{ $order->price_per_ton }} грн</td>
                <td>{{ $order->transport_cost }} грн</td>
                <td>{{ $order->notes ?? '—' }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>

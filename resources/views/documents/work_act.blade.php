<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Акт про виконані роботи</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; line-height: 1.4; margin: 10px; }
        h1 { text-align: center; font-size: 18px; margin-bottom: 10px; }
        p { margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid  #000; padding: 6px; text-align: left; font-size: 14px; }
        th { background-color: #f2f2f2; }
        .details, .totals { margin-top: 15px; }
        .totals td { font-weight: bold; }
        .signature { margin-top: 20px; font-size: 14px; }
    </style>
</head>
<body>
    <h1>Акт про виконані роботи</h1>

    <!-- Інформація про замовлення -->
    <p><strong>Номер замовлення:</strong> {{ $order->id }}</p>
    <p><strong>Дата завантаження:</strong> {{ \Carbon\Carbon::parse($order->loading_date)->format('d.m.Y') }}</p>
    <p><strong>Дата розвантаження:</strong> {{ \Carbon\Carbon::parse($order->unloading_date)->format('d.m.Y') }}</p>
    <p><strong>Замовник:</strong> {{ $order->client }}</p>
    <p><strong>Контактний номер:</strong> {{ $order->phone }}</p>
    <p><strong>Місце завантаження:</strong> {{ $order->loading_place }}</p>
    <p><strong>Місце розвантаження:</strong> {{ $order->unloading_place }}</p>

    <!-- Деталі виконаних робіт -->
    <div class="details">
        <h2>Деталі виконаних робіт</h2>
        <table>
            <thead>
                <tr>
                    <th>Назва роботи</th>
                    <th>Кількість</th>
                    <th>Одиниця виміру</th>
                    <th>Вартість за одиницю, грн</th>
                    <th>Загальна вартість, грн</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Перевезення вантажу ({{ $order->cargo_type }})</td>
                    <td>{{ $order->grain_quantity }}</td>
                    <td>тон</td>
                    <td>{{ number_format($order->price_per_ton, 2) }} грн</td>
                    <td>{{ number_format($order->grain_quantity * $order->price_per_ton, 2) }} грн</td>
                </tr>
                <tr>
                    <td>Транспортні витрати</td>
                    <td colspan="3"></td>
                    <td>{{ number_format($order->transport_cost, 2) }} грн</td>
                </tr>
                <tr>
                    <td colspan="4" style="font-weight: bold;">Загальна вартість послуг:</td>
                    <td style="font-weight: bold;">{{ number_format($order->transport_cost + ($order->grain_quantity * $order->price_per_ton), 2) }} грн</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Примітки -->
    @if ($order->notes)
        <p><strong>Примітки:</strong> {{ $order->notes }}</p>
    @endif

    <!-- Підпис -->
    <div class="signature">
        <p>Підпис виконавця: ________________________</p>
        <p>Підпис замовника: ________________________</p>
    </div>
</body>
</html>
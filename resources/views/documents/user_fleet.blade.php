<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Звіт про автопарк користувача</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1 { text-align: center; font-size: 18px; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid black; text-align: left; }
        th { background-color: #f2f2f2; }
        td { text-align: center; } /* Вирівнюємо текст по центру */
        .header { text-align: center; } /* Заголовок таблиці */
    </style>
</head>
<body>
    <h1 class="header">Звіт про автопарк</h1>
    <table>
        <thead>
            <tr>
                <th>Бренд</th>
                <th>Модель</th>
                <th>Рік випуску</th>
                <th>Номерний знак</th>
                <th>Пробіг</th> 
                <th>Стан</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trucks as $truck)
                <tr>
                    <td>{{ $truck->brand }}</td>
                    <td>{{ $truck->model }}</td>
                    <td>{{ $truck->year }}</td>
                    <td>{{ $truck->license_plate }}</td>
                    <td>
                        @if($truck->mileages->isNotEmpty())
                            {{ $truck->mileages->first()->mileage }} км
                        @else
                            Немає даних
                        @endif
                    </td> 
                    <td>{{ $truck->condition }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

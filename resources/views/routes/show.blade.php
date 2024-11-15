<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мої маршрути</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid black;
        }
        th {
            background-color: #f2f2f2;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .back-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
            margin-top: 20px;
        }
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <h1>Збережені маршрути</h1>

    @if ($routes->isEmpty())
        <p>У вас ще немає збережених маршрутів.</p>
    @else
        <table border="1">
            <thead>
                <tr>
                    <th>Початкова адреса</th>
                    <th>Кінцева адреса</th>
                    <th>Відстань (км)</th>
                    <th>Час в дорозі (хв)</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($routes as $route)
                    <tr>
                        <td>{{ $route->start_location }}</td>
                        <td>{{ $route->end_location }}</td>
                        <td>{{ number_format($route->distance, 2) }}</td>
                        <td>{{ number_format($route->duration, 2) }}</td>
                        <td>
                            <form action="{{ route('delete.route', $route->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Видалити</button>
                            </form>
                            <button onclick="showRoute({{ $route->id }})">Показати на карті</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div id="map"></div>

    <a href="{{ route('routes') }}" class="back-link">Назад на головну</a>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        // Ініціалізація карти
        var map = L.map('map').setView([48.3794, 31.1656], 6); // Центр України

        // Додавання шару з OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Функція для показу маршруту
        function showRoute(routeId) {
            fetch(`/routes/${routeId}`) // Виклик API для отримання маршруту
                .then(response => response.json())
                .then(data => {
                    if (data.geometry) {
                        // Видалення попередніх маршрутів
                        if (window.currentRouteLayer) {
                            map.removeLayer(window.currentRouteLayer);
                        }
                        // Додавання нового маршруту
                        var routeCoords = L.geoJSON(data.geometry);
                        routeCoords.addTo(map);
                        window.currentRouteLayer = routeCoords;

                        // Центруємо карту на маршруті
                        map.fitBounds(routeCoords.getBounds());
                    } else {
                        alert('Маршрут не знайдено.');
                    }
                });
        }

        // Функція підтвердження перед видаленням
        function confirmDelete() {
            return confirm("Ви впевнені, що хочете видалити цей маршрут?");
        }
    </script>
</body>
</html>

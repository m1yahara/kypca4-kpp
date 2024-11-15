<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Прокладання маршруту</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map { height: 500px; width: 100%; }
        .form-container { margin: 20px 0; }
        input[type="text"] {
            padding: 10px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            outline: none;
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
        .my-routes-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<h1>Оберіть початкову та кінцеву адресу, щоб прокласти оптимальний маршрут</h1>

<div class="form-container">
    <form id="route-form">
        <input type="text" id="start" name="start_location" placeholder="Початкова адреса" required>
        <input type="text" id="end" name="end_location" placeholder="Кінцева адреса" required>
        <button type="submit">Прокласти маршрут</button>
    </form>
    <button id="save-route" style="display:none;">Зберегти маршрут</button>
</div>

<div id="map"></div>
<a href="home" class="back-link">Назад на головну</a>
<a href="{{ route('my.routes') }}" class="my-routes-button">Збережені маршрути</a> 


<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script>
    // Ініціалізація карти
    var map = L.map('map').setView([49.8397, 24.0297], 13); // Початкове положення (наприклад, Львів)
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    var routeLayer; // Змінна для шару з маршрутом

    // Обробка форми для розрахунку маршруту
    document.getElementById('route-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        var startLocation = document.getElementById('start').value;
        var endLocation = document.getElementById('end').value;

        axios.post("{{ route('calculate.route') }}", {
            start_location: startLocation,
            end_location: endLocation
        })
        .then(function (response) {
            if (response.data.geometry) {
                var routeCoordinates = response.data.geometry.coordinates.map(coord => [coord[1], coord[0]]); // Перетворюємо на формат [lat, lon]
                
                // Видаляємо попередній маршрут, якщо він є
                if (routeLayer) {
                    map.removeLayer(routeLayer);
                }

                // Додаємо маршрут на карту
                routeLayer = L.polyline(routeCoordinates, { color: 'blue' }).addTo(map);
                map.fitBounds(routeLayer.getBounds());

                // Виводимо інформацію про маршрут
                alert(`Відстань: ${response.data.distance.toFixed(2)} км\nЧас в дорозі: ${response.data.duration.toFixed(2)} хвилин`);

                // Показуємо кнопку "Зберегти маршрут"
                document.getElementById('save-route').style.display = 'block';

                // Зберігаємо дані маршруту для подальшого збереження
                document.getElementById('save-route').dataset.start = startLocation;
                document.getElementById('save-route').dataset.end = endLocation;
                document.getElementById('save-route').dataset.distance = response.data.distance;
                document.getElementById('save-route').dataset.duration = response.data.duration;
                document.getElementById('save-route').dataset.geometry = JSON.stringify(response.data.geometry);
            }
        })
        .catch(function (error) {
            console.error("Помилка розрахунку маршруту:", error);
            alert("Не вдалося розрахувати маршрут. Перевірте адреси та спробуйте знову.");
        });
    });

    // Обробка збереження маршруту
    document.getElementById('save-route').addEventListener('click', function() {
        axios.post("{{ route('save.route') }}", {
            start_location: this.dataset.start,
            end_location: this.dataset.end,
            distance: this.dataset.distance,
            duration: this.dataset.duration,
            geometry: JSON.parse(this.dataset.geometry)
        })
        .then(function (response) {
            alert(response.data.success || "Маршрут збережено успішно");
            document.getElementById('save-route').style.display = 'none';
        })
        .catch(function (error) {
            console.error("Помилка при збереженні маршруту:", error);
            alert("Не вдалося зберегти маршрут.");
        });
    });
</script>

</body>
</html>

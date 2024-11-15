<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <!-- Підключення CSS -->
    <title>Система обліку зерноперевезень</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Бічна панель -->
            <nav class="col-md-3 col-lg-2 sidebar">
                <img src="{{ asset('image/truck.png') }}" alt="Фура" style="width: 100%; height: auto;">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="\orders">Замовлення</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="\trucks">Транспорт</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="\routes">Маршрути</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="\finances">Фінанси</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="\documents">Документи</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Основний контент -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-4">
                <h1 class="mt-3">Ласкаво просимо до системи обліку зерноперевезень!</h1>
                <p>Ця система призначена для оптимізації процесу обліку замовлень на перевезення зерна. Завдяки їй ви зможете:</p>
                <ul>
                    <li>Створювати та редагувати замовлення на перевезення.</li>
                    <li>Управляти інформацією про транспортні засоби.</li>
                    <li>Планувати оптимальні маршрути перевезення.</li>
                    <li>Cтатистика фінансових операцій, доходів та витрат.</li>
                    <li>Генерувати та зберігати документи, пов'язані з різними аспектами системи обліку.</li>
                </ul>
                <p>Використовуйте навігацію зліва, щоб швидко перейти до потрібного функціоналу.</p>
            </main>
        </div>
    </div>
</body>
</html>

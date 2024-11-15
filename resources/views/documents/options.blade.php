<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Генерація документів</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #4a4a4a;
        }
        h2 {
            color: #5a5a5a;
            margin-top: 30px;
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        select, input[type="date"], button {
            margin: 10px 5px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            background-color: #28a745;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #218838;
        }
        .date-input {
            display: none; /* Сховати поля дати за замовчуванням */
        }
        .error {
            color: red;
            margin-top: 10px;
        }
        .btn {
           display: inline-block;
           background-color: #6c757d; 
           color: white;
           padding: 10px 15px; 
           border: none; 
           border-radius: 4px; 
           text-align: center; 
           text-decoration: none; 
           cursor: pointer; 
           transition: background-color 0.3s; 
        }       
    </style>

    <script>
        function toggleDateInputs(selectElement) {
            const form = selectElement.closest('form'); 
            const dateInputs = form.querySelectorAll('.date-input'); 
            dateInputs.forEach(input => input.style.display = (selectElement.value === 'custom') ? 'inline' : 'none');
        }

        function validateDates(startDateInput, endDateInput) {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            const errorMessage = startDateInput.closest('form').querySelector('.error');

            if (startDateInput.value && endDateInput.value && startDate > endDate) {
                errorMessage.textContent = "Початкова дата не може бути пізніше кінцевої!!!";
                return false;
            } else {
                errorMessage.textContent = ""; 
                return true;
            }
        }
    </script>
</head>
<body>
    <h1>Генерація документів</h1>
    <a href="{{ route('home') }}" class="btn btn-secondary">Повернутись на домашню сторінку</a>

    <h2>1. Акт про виконану роботу за певним замовленням</h2>
    <form action="{{ route('documents.work_act', ':orderId') }}" method="get" onsubmit="this.action = this.action.replace(':orderId', this.order_id.value);">
        <select name="order_id" required>
            <option value="">Оберіть замовлення</option>
            @foreach ($orders as $order)
                <option value="{{ $order->id }}">{{ $order->id }} - {{ $order->client }}</option>
            @endforeach
        </select>
        <button type="submit">Згенерувати Акт</button>
    </form>

    <h2>2. Звіт про доходи за певний період</h2>
    <form action="{{ route('documents.incomeReportPdf') }}" method="get" onsubmit="return validateDates(start_date, end_date)">
        <select name="period" onchange="toggleDateInputs(this)" required>
            <option value="month">За місяць</option>
            <option value="week">За тиждень</option>
            <option value="custom">Користувацький період</option>
        </select>
        <input type="date" name="start_date" id="start_date" class="date-input" onchange="validateDates(this, document.getElementById('end_date'))">
        <input type="date" name="end_date" id="end_date" class="date-input" onchange="validateDates(document.getElementById('start_date'), this)">
        <div class="error"></div>
        <button type="submit">Згенерувати Звіт</button>
    </form>

    <h2>3. Звіт про витрати за певний період</h2>
    <form action="{{ route('documents.expenseReportPdf') }}" method="get" onsubmit="return validateDates(start_date_expense, end_date_expense)">
        <select name="period" onchange="toggleDateInputs(this)" required>
            <option value="month">За місяць</option>
            <option value="week">За тиждень</option>
            <option value="custom">Користувацький період</option>
        </select>
        <input type="date" name="start_date" id="start_date_expense" class="date-input" onchange="validateDates(this, document.getElementById('end_date_expense'))">
        <input type="date" name="end_date" id="end_date_expense" class="date-input" onchange="validateDates(document.getElementById('start_date_expense'), this)">
        <div class="error"></div>
        <button type="submit">Згенерувати Звіт</button>
    </form>

    <h2>4. Повний фінансовий звіт за певний період</h2>
    <form action="{{ route('documents.financialReportPdf') }}" method="get" onsubmit="return validateDates(start_date_financial, end_date_financial)">
        <select name="period" onchange="toggleDateInputs(this)" required>
            <option value="month">За місяць</option>
            <option value="week">За тиждень</option>
            <option value="custom">Користувацький період</option>
        </select>
        <input type="date" name="start_date" id="start_date_financial" class="date-input" onchange="validateDates(this, document.getElementById('end_date_financial'))">
        <input type="date" name="end_date" id="end_date_financial" class="date-input" onchange="validateDates(document.getElementById('start_date_financial'), this)">
        <div class="error"></div>
        <button type="submit">Згенерувати Звіт</button>
    </form>

    <h2>5. Історія пробігів за певною вантажівкою</h2>
    <form action="{{ route('documents.mileage_history', ':truckId') }}" method="get" onsubmit="this.action = this.action.replace(':truckId', this.truck_id.value);">
        <select name="truck_id" required>
            <option value="">Оберіть вантажівку</option>
            @foreach ($trucks as $truck)
                <option value="{{ $truck->id }}">{{ $truck->brand }} {{ $truck->model }}</option>
            @endforeach
        </select>
        <button type="submit">Згенерувати Історію пробігів</button>
    </form>

    <h2>6. Звіт про усі замовлення за певний період</h2>
    <form action="{{ route('documents.all_orders') }}" method="get" onsubmit="return validateDates(start_date_all, end_date_all)">
        <select name="period" onchange="toggleDateInputs(this)" required>
            <option value="month">За місяць</option>
            <option value="week">За тиждень</option>
            <option value="custom">Користувацький період</option>
        </select>
        <input type="date" name="start_date" id="start_date_all" class="date-input" onchange="validateDates(this, document.getElementById('end_date_all'))">
        <input type="date" name="end_date" id="end_date_all" class="date-input" onchange="validateDates(document.getElementById('start_date_all'), this)">
        <div class="error"></div>
        <button type="submit">Згенерувати Звіт</button>
    </form>

    <h2>7. Звіт про автопарк користувача</h2>
    <form action="{{ route('documents.user_fleet') }}" method="get">
        <button type="submit">Згенерувати Звіт про автопарк</button>
    </form>
</body>
</html>

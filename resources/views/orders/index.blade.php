@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Список замовлень</h1>

    <div class="mb-3 d-inline-flex">
        <a href="{{ route('orders.create') }}" class="btn btn-success me-2">Додати нове замовлення</a>
        <a href="{{ route('home') }}" class="btn btn-secondary">Повернутись на домашню сторінку</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped table-hover align-middle">
        <thead>
            <tr>
                <th>Клієнт</th>
                <th>Номер телефону</th>
                <th>Місце завантаження</th>
                <th>Місце розвантаження</th>
                <th>Кількість (тонни)</th>
                <th>Ціна за тонну</th>
                <th>Загальна вартість</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->client }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->loading_place }}</td>
                    <td>{{ $order->unloading_place }}</td>
                    <td>{{ $order->grain_quantity }}</td>
                    <td>{{ $order->price_per_ton }}</td>
                    <td>{{ $order->transport_cost }}</td>
                    <td>
                        <div class="action-buttons d-flex flex-column align-items-stretch">
                            <div class="d-flex">
                                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning flex-fill me-1">Редагувати</a>
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="flex-grow: 1;" onsubmit="return confirm('Ви впевнені, що хочете видалити це замовлення?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">Видалити</button>
                                </form>
                            </div>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-block mt-1">Переглянути деталі</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
    /* Вирівнювання по центру для заголовків і комірок */
    table th, table td {
        vertical-align: middle;
        text-align: center;
        padding: 10px;
    }

    /* Стиль для дій, щоб кнопки були блоковими */
    .action-buttons a, .action-buttons button {
        display: block;
    }

    /* Висота рядків */
    table tbody tr {
        height: 70px; /* Рівномірна висота для всіх рядків */
    }

    .btn-block {
        width: 100%; /* Кнопки на всю ширину */
    }
</style>
@endsection

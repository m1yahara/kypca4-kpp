<!-- resources/views/orders/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Деталі замовлення #{{ $order->id }}</h1>
    
    <ul class="list-group mb-3">
        <li class="list-group-item"><strong>Клієнт:</strong> {{ $order->client }}</li>
        <li class="list-group-item"><strong>Телефон:</strong> {{ $order->phone }}</li>
        <li class="list-group-item"><strong>Місце завантаження:</strong> {{ $order->loading_place }}</li>
        <li class="list-group-item"><strong>Місце розвантаження:</strong> {{ $order->unloading_place }}</li>
        <li class="list-group-item"><strong>Дата завантаження:</strong> {{ $order->loading_date }}</li>
        <li class="list-group-item"><strong>Дата розвантаження:</strong> {{ $order->unloading_date }}</li>
        <li class="list-group-item"><strong>Тип вантажу:</strong> {{ $order->cargo_type }}</li>
        <li class="list-group-item"><strong>Кількість (тонни):</strong> {{ $order->grain_quantity }}</li>
        <li class="list-group-item"><strong>Ціна за тонну:</strong> {{ $order->price_per_ton }}</li>
        <li class="list-group-item"><strong>Загальна вартість:</strong> {{ $order->transport_cost }}</li>
        <li class="list-group-item"><strong>Примітки:</strong> {{ $order->notes }}</li>
    </ul>
    
    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Назад до списку</a>
    <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning">Редагувати</a>
</div>
@endsection

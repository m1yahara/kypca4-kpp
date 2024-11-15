@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Редагування замовлення</h1>
    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="client" class="form-label">Клієнт</label>
            <input type="text" class="form-control" id="client" name="client" value="{{ old('client', $order->client) }}" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Номер телефону</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $order->phone) }}" required>
        </div>

        <div class="mb-3">
            <label for="loading_place" class="form-label">Місце завантаження</label>
            <input type="text" class="form-control" id="loading_place" name="loading_place" value="{{ old('loading_place', $order->loading_place) }}" required>
        </div>

        <div class="mb-3">
            <label for="unloading_place" class="form-label">Місце розвантаження</label>
            <input type="text" class="form-control" id="unloading_place" name="unloading_place" value="{{ old('unloading_place', $order->unloading_place) }}" required>
        </div>

        <div class="mb-3">
            <label for="loading_date" class="form-label">Дата завантаження</label>
            <input type="date" class="form-control" id="loading_date" name="loading_date" value="{{ old('loading_date', $order->loading_date) }}" required>
        </div>

        <div class="mb-3">
            <label for="unloading_date" class="form-label">Дата розвантаження</label>
            <input type="date" class="form-control" id="unloading_date" name="unloading_date" value="{{ old('unloading_date', $order->unloading_date) }}" required>
        </div>

        <div class="mb-3">
            <label for="cargo_type" class="form-label">Тип вантажу</label>
            <input type="text" class="form-control" id="cargo_type" name="cargo_type" value="{{ old('cargo_type', $order->cargo_type) }}" required>
        </div>

        <div class="mb-3">
            <label for="grain_quantity" class="form-label">Кількість (тонни)</label>
            <input type="number" class="form-control" id="grain_quantity" name="grain_quantity" step="0.1" value="{{ old('grain_quantity', $order->grain_quantity) }}" required>
        </div>

        <div class="mb-3">
            <label for="price_per_ton" class="form-label">Ціна за тонну</label>
            <input type="number" class="form-control" id="price_per_ton" name="price_per_ton" step="0.1" value="{{ old('price_per_ton', $order->price_per_ton) }}" required>
        </div>

        <div class="mb-3">
            <label for="transport_cost" class="form-label">Загальна вартість</label>
            <input type="text" class="form-control" id="transport_cost" name="transport_cost" readonly>
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Додаткові примітки</label>
            <textarea class="form-control" id="notes" name="notes">{{ old('notes', $order->notes) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Зберегти замовлення</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Назад до списку</a>
    </form>
</div>

<script>
    const quantityInput = document.getElementById('grain_quantity');
    const pricePerTonInput = document.getElementById('price_per_ton');
    const totalPriceInput = document.getElementById('transport_cost');

    function calculateTransportCost() {
        const quantity = parseFloat(quantityInput.value) || 0;  
        const pricePerTon = parseFloat(pricePerTonInput.value) || 0;
        totalPriceInput.value = (quantity * pricePerTon).toFixed(2);
    }

 
    quantityInput.addEventListener('input', calculateTransportCost);
    pricePerTonInput.addEventListener('input', calculateTransportCost);

    document.addEventListener('DOMContentLoaded', calculateTransportCost);
</script>

@endsection

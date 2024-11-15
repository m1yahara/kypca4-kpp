@extends('layouts.app')

@section('content')
    <h1>Додати пробіг для {{ $truck->brand }} {{ $truck->model }} ({{ $truck->license_plate }})</h1>

   
    <form action="{{ route('truck_mileages.store', $truck->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="date" class="form-label">Дата</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        @if($lastMileage)
            <p>Останній пробіг: {{ $lastMileage->mileage }} км </p>
        @else
            <p>Останній пробіг: дані відсутні</p>
        @endif

        <div class="mb-3">
            <label for="mileage" class="form-label">Загальний пробіг</label>
            <input type="number" name="mileage" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="fuel_cost_per_100km" class="form-label">Витрати на паливо на 100 км</label>
            <input type="number" name="fuel_cost_per_100km" step="0.01" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="amortization_cost_per_100km" class="form-label">Амортизація на 100 км</label>
            <input type="number" name="amortization_cost_per_100km" step="0.01" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Додати</button>
        <a href="{{ route('truck_mileages.index', $truck->id) }}" class="btn btn-secondary">Назад до історії пробігів</a>
    </form>
@endsection

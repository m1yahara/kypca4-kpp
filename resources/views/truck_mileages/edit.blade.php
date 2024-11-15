@extends('layouts.app')

@section('content')
    <h1>Редагувати пробіг для {{ $truck->make }} {{ $truck->model }} ({{ $truck->license_plate }})</h1>

    <form action="{{ route('truck_mileages.update', [$truck->id, $mileage->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="date" class="form-label">Дата</label>
            <input type="date" name="date" class="form-control" value="{{ $mileage->date }}" required>
        </div>

        <div class="mb-3">
            <label for="mileage" class="form-label">Загальний пробіг</label>
            <input type="number" name="mileage" class="form-control" value="{{ $mileage->mileage }}" required>
        </div>

        <div class="mb-3">
            <label for="fuel_cost_per_100km" class="form-label">Витрати на паливо на 100 км</label>
            <input type="number" name="fuel_cost_per_100km" step="0.01" class="form-control" value="{{ $mileage->fuel_cost_per_100km }}" required>
        </div>

        <div class="mb-3">
            <label for="amortization_cost_per_100km" class="form-label">Амортизація на 100 км</label>
            <input type="number" name="amortization_cost_per_100km" step="0.01" class="form-control" value="{{ $mileage->amortization_cost_per_100km }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Оновити</button>
        <a href="{{ route('truck_mileages.index', $truck->id) }}" class="btn btn-secondary">Назад до історії пробігів</a>
    </form>
@endsection

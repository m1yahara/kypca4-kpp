@extends('layouts.app')

@section('content')
    <h1>Історія пробігу {{ $truck->make }} {{ $truck->brand }} {{ $truck->model }} ({{ $truck->license_plate }})</h1>

    <div class="mb-3">
        <a href="{{ route('truck_mileages.create', $truck->id) }}" class="btn btn-primary">Додати запис пробігу</a>
        <a href="{{ route('trucks.index') }}" class="btn btn-secondary">Назад до списку</a>
    </div>

    <table class="table mt-4 custom-table">
        <thead>
            <tr>
                <th style="width: 10%;">Дата</th>
                <th style="width: 14%;">Загальний пробіг</th>
                <th style="width: 23%;">Витрати на паливо (100 км)</th>
                <th style="width: 17%;">Амортизація (100 км)</th>
                <th style="width: 22%;">Загальні витрати на паливо</th>
                <th style="width: 50%;">Загальні витрати на амортизацію</th>
                <th style="width: 10%;">Дії</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mileages as $mileage)
                <tr>
                    <td>{{ $mileage->date }}</td>
                    <td>{{ $mileage->mileage }} км</td>
                    <td>{{ $mileage->fuel_cost_per_100km }} грн</td>
                    <td>{{ $mileage->amortization_cost_per_100km }} грн</td>
                    <td>{{ $mileage->total_fuel_cost }} грн</td>
                    <td>{{ $mileage->total_amortization_cost }} грн</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('truck_mileages.edit', [$truck->id, $mileage->id]) }}" class="btn btn-warning btn-sm me-2">Редагувати</a>
                            
                            <form action="{{ route('truck_mileages.destroy', [$truck->id, $mileage->id]) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Ви впевнені, що хочете видалити цей запис?')">Видалити</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

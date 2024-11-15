@extends('layouts.app')

@section('content')
    <h1>Список вантажівок</h1>

    <a href="{{ route('trucks.create') }}" class="btn btn-primary mb-2">Додати нову вантажівку</a>
    <a href="{{ route('trailers.index') }}" class="btn btn-success mb-2">Причіпи</a>
    <a href="{{ route('home') }}" class="btn btn-secondary mb-2">Повернутись на домашню сторінку</a>
    
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Марка</th>
                <th>Модель</th>
                <th>Рік випуску</th>
                <th>Номерний знак</th>
                <th>Вантажопідйомність (т)</th>
                <th>Технічний стан</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trucks as $truck)
                <tr>
                    <td>{{ $truck->brand }}</td>
                    <td>{{ $truck->model }}</td>
                    <td>{{ $truck->year }}</td>
                    <td>{{ $truck->license_plate }}</td>
                    <td>{{ $truck->load_capacity }}</td>
                    <td>{{ $truck->condition }}</td>
                    <td>
                        <a href="{{ route('trucks.show', $truck->id) }}" class="btn btn-info btn-sm mb-1">Переглянути вантажівку</a>
                        
                        <a href="{{ route('trucks.edit', $truck->id) }}" class="btn btn-warning btn-sm mb-1">Редагувати</a>
                        <br>
                        <a href="{{ route('truck_mileages.index', $truck->id) }}" class="btn btn-warning btn-sm mb-1">Переглянути пробіг</a>
                        <form action="{{ route('trucks.destroy', $truck->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Ви впевнені?')">Видалити</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

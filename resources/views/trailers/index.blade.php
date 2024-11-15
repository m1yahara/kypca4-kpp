<!-- resources/views/trailers/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Список причепів</h1>

    <a href="{{ route('trailers.create') }}" class="btn btn-primary">Додати новий причіп</a>
    <a href="{{ route('trucks.index') }}" class="btn btn-success">Вантажівки</a>
    <a href="{{ route('home') }}" class="btn btn-secondary">Повернутись на домашню сторінку</a>
    
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Марка</th>
                <th>Модель</th>
                <th>Рік випуску</th>
                <th>Номерний знак</th>
                <th>Тип причепа</th>
                <th>Вантажопідйомність</th>
                <th>Технічний стан</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trailers as $trailer)
                <tr>
                    <td>{{ $trailer->brand }}</td>
                    <td>{{ $trailer->model }}</td>
                    <td>{{ $trailer->year }}</td>
                    <td>{{ $trailer->license_plate }}</td>
                    <td>{{ $trailer->type }}</td>
                    <td>{{ $trailer->load_capacity }} т.</td>
                    <td>{{ $trailer->condition }}</td>
                    <td>
                        <a href="{{ route('trailers.show', $trailer->id) }}" class="btn btn-info btn-sm">Переглянути</a>
                        <a href="{{ route('trailers.edit', $trailer->id) }}" class="btn btn-warning btn-sm">Редагувати</a>
                        <form action="{{ route('trailers.destroy', $trailer->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Ви впевнені?')">Видалити</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

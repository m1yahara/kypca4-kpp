<!-- resources/views/trailers/create.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Додати новий причіп</h1>

    <form action="{{ route('trailers.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Марка</label>
            <input type="text" name="brand" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Модель</label>
            <input type="text" name="model" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Рік випуску</label>
            <input type="number" name="year" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Номерний знак</label>
            <input type="text" name="license_plate" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Тип причепа</label>
            <input type="text" name="type" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Вантажопідйомність (т)</label>
            <input type="number" name="load_capacity" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Технічний стан</label>
            <input type="text" name="condition" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Транспортний засіб</label>
            <select name="truck_id" class="form-control" required>
                <option value="">Оберіть транспортний засіб</option>
                @foreach($trucks as $truck)
                    <option value="{{ $truck->id }}">{{ $truck->brand }} {{ $truck->model }} ({{ $truck->license_plate }})</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Зберегти</button>
        <a href="{{ route('trailers.index') }}" class="btn btn-secondary">Назад до списку</a>
    </form>
@endsection

<!-- resources/views/trucks/create.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Додати нову вантажівку</h1>

    <form action="{{ route('trucks.store') }}" method="POST">
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
            <label>Вантажопідйомність (кг)</label>
            <input type="number" name="load_capacity" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Технічний стан</label>
            <input type="text" name="condition" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Зберегти</button>
        <a href="{{ route('trucks.index') }}" class="btn btn-secondary">Назад до списку</a>
    </form>
@endsection

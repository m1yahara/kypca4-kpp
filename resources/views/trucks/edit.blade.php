<!-- resources/views/trucks/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Редагувати вантажівку</h1>

    <form action="{{ route('trucks.update', $truck->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Марка</label>
            <input type="text" name="brand" class="form-control" value="{{ $truck->brand }}" required>
        </div>
        
        <div class="form-group">
            <label>Модель</label>
            <input type="text" name="model" class="form-control" value="{{ $truck->model }}" required>
        </div>
        
        <div class="form-group">
            <label>Рік випуску</label>
            <input type="number" name="year" class="form-control" value="{{ $truck->year }}" required>
        </div>
        
        <div class="form-group">
            <label>Номерний знак</label>
            <input type="text" name="license_plate" class="form-control" value="{{ $truck->license_plate }}" required>
        </div>
        
        <div class="form-group">
            <label>Вантажопідйомність (т)</label>
            <input type="number" name="load_capacity" class="form-control" value="{{ $truck->load_capacity }}" required>
        </div>
        
        <div class="form-group">
            <label>Технічний стан</label>
            <input type="text" name="condition" class="form-control" value="{{ $truck->condition }}" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Оновити</button>
        <a href="{{ route('trucks.index') }}" class="btn btn-secondary">Назад до списку</a>
    </form>
@endsection

<!-- resources/views/trailers/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Редагувати причіп</h1>

    <form action="{{ route('trailers.update', $trailer->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Марка</label>
            <input type="text" name="brand" class="form-control" value="{{ $trailer->brand }}" required>
        </div>
        
        <div class="form-group">
            <label>Модель</label>
            <input type="text" name="model" class="form-control" value="{{ $trailer->model }}" required>
        </div>
        
        <div class="form-group">
            <label>Рік випуску</label>
            <input type="number" name="year" class="form-control" value="{{ $trailer->year }}" required>
        </div>
        
        <div class="form-group">
            <label>Номерний знак</label>
            <input type="text" name="license_plate" class="form-control" value="{{ $trailer->license_plate }}" required>
        </div>
        
        <div class="form-group">
            <label>Тип причепа</label>
            <input type="text" name="type" class="form-control" value="{{ $trailer->type }}" required>
        </div>

        <div class="form-group">
            <label>Вантажопідйомність (т)</label>
            <input type="number" name="load_capacity" class="form-control" value="{{ $trailer->load_capacity }}" required>
        </div>
        
        <div class="form-group">
            <label>Технічний стан</label>
            <input type="text" name="condition" class="form-control" value="{{ $trailer->condition }}" required>
        </div>

        <div class="form-group">
            <label>Транспортний засіб</label>
            <select name="truck_id" class="form-control" required>
                <option value="">Оберіть транспортний засіб</option>
                @foreach($trucks as $truck)
                    <option value="{{ $truck->id }}" {{ $trailer->truck_id == $truck->id ? 'selected' : '' }}>
                        {{ $truck->brand }} {{ $truck->model }} ({{ $truck->license_plate }})
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Оновити</button>
        <a href="{{ route('trailers.index') }}" class="btn btn-secondary">Назад до списку</a>
    </form>
@endsection


<!-- resources/views/trucks/show.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Деталі вантажівки</h1>

    <p><strong>Марка:</strong> {{ $truck->brand }}</p>
    <p><strong>Модель:</strong> {{ $truck->model }}</p>
    <p><strong>Рік випуску:</strong> {{ $truck->year }}</p>
    <p><strong>Номерний знак:</strong> {{ $truck->license_plate }}</p>
    <p><strong>Вантажопідйомність (т):</strong> {{ $truck->load_capacity }} </p>
    <p><strong>Технічний стан:</strong> {{ $truck->condition }}</p>

    <a href="{{ route('trucks.edit', $truck->id) }}" class="btn btn-warning">Редагувати</a>
    
    <a href="{{ route('trucks.index') }}" class="btn btn-secondary">Назад до списку</a>
@endsection


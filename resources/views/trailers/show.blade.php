@extends('layouts.app')

@section('content')
    <h1>Деталі причепа</h1>

    <p><strong>Марка:</strong> {{ $trailer->brand }}</p>
    <p><strong>Модель:</strong> {{ $trailer->model }}</p>
    <p><strong>Рік випуску:</strong> {{ $trailer->year }}</p>
    <p><strong>Номерний знак:</strong> {{ $trailer->license_plate }}</p>
    <p><strong>Тип причепа:</strong> {{ $trailer->type }}</p>
    <p><strong>Вантажопідйомність:</strong> {{ $trailer->load_capacity }} т.</p>
    <p><strong>Технічний стан:</strong> {{ $trailer->condition }}</p>
    
    @if($truck)
        <div>
            <strong>Транспортний засіб:</strong> {{ $truck->model }} {{ $truck->brand }} ({{ $truck->license_plate }})
        </div>
    @else
        <p>Транспортний засіб не прив’язаний до цього причепа.</p>
    @endif

    <div style="margin-top: 15px;"> 
        <a href="{{ route('trailers.edit', $trailer->id) }}" class="btn btn-warning">Редагувати</a>
        <a href="{{ route('trailers.index') }}" class="btn btn-secondary">Назад до списку</a>
    </div>
@endsection

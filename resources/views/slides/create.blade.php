@extends('layouts.app')

@section('title', 'Crear diapositiva')

@section('content')
    <h2>Crear diapositiva manual</h2>

    <div class="card">
        <form action="{{ route('slides.store') }}" method="POST">
            @csrf
            @include('slides._form')
        </form>
    </div>
@endsection


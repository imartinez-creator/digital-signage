@extends('layouts.app')

@section('title', 'Editar diapositiva')

@section('content')
    <h2>Editar diapositiva manual</h2>

    <div class="card">
        <form action="{{ route('slides.update', $slide) }}" method="POST">
            @csrf
            @method('PUT')
            @include('slides._form')
        </form>
    </div>
@endsection



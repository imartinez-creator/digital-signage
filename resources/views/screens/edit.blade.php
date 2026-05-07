@extends('layouts.app')

@section('title', 'Editar pantalla')

@section('content')
    <h2>Editar pantalla</h2>

    <div class="card">
        <form action="{{ route('screens.update', $screen) }}" method="POST">
            @csrf
            @method('PUT')
            @include('screens._form')
        </form>
    </div>
@endsection



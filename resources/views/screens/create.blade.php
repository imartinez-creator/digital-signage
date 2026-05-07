@extends('layouts.app')

@section('title', 'Crear pantalla')

@section('content')
    <h2>Crear pantalla</h2>

    <div class="card">
        <form action="{{ route('screens.store') }}" method="POST">
            @csrf
            @include('screens._form')
        </form>
    </div>
@endsection


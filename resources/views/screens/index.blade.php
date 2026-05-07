@extends('layouts.app')

@section('title', 'Pantalles')

@section('content')
    <h2>Pantalles del centre</h2>

    <p>
        <a class="btn" href="{{ route('screens.create') }}">Crear nova pantalla</a>
    </p>

    <table>
        <thead>
        <tr>
            <th>Nom</th>
            <th>Identificador</th>
            <th>Estat</th>
            <th>Ordre contingut</th>
            <th>Diapositives assignades</th>
            <th>Visualitzador</th>
            <th>Accions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($screens as $screen)
            <tr>
                <td>{{ $screen->name }}</td>
                <td>{{ $screen->slug }}</td>
                <td>
                    @if($screen->is_blocked)
                        <span class="badge badge-red">Bloquejada</span>
                    @else
                        <span class="badge badge-green">Activa</span>
                    @endif
                </td>
                <td>
                    @if($screen->content_order === 'manual_first')
                        Manuals abans
                    @else
                        Notícies web abans
                    @endif
                </td>
                <td>
                    @forelse($screen->manualSlides as $slide)
                        <span class="badge">{{ $slide->title }}</span>
                    @empty
                        Cap diapositiva assignada
                    @endforelse
                </td>
                <td>
                    <a class="btn btn-secondary" target="_blank" href="{{ route('player.show', $screen) }}">
                        Obrir pantalla
                    </a>
                </td>
                <td>
                    <a class="btn btn-secondary" href="{{ route('screens.edit', $screen) }}">Editar</a>

                    <form action="{{ route('screens.destroy', $screen) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">Encara no hi ha pantalles creades.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection


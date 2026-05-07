@extends('layouts.app')

@section('title', 'Diapositives manuals')

@section('content')
    <h2>Diapositives manuals</h2>

    <p>
        <a class="btn" href="{{ route('slides.create') }}">Crear nova diapositiva</a>
    </p>

    <table>
        <thead>
        <tr>
            <th>Ordre</th>
            <th>Títol</th>
            <th>Estat</th>
            <th>Fixada</th>
            <th>Accions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($slides as $slide)
            <tr>
                <td>{{ $slide->sort_order }}</td>
                <td>
                    <strong>{{ $slide->title }}</strong><br>
                    {{ Str::limit($slide->body, 100) }}
                </td>
                <td>
                    @if($slide->is_active)
                        <span class="badge badge-green">Activa</span>
                    @else
                        <span class="badge badge-red">Inactiva</span>
                    @endif
                </td>
                <td>
                    @if($slide->is_pinned)
                        <span class="badge badge-yellow">Fixada</span>
                    @else
                        <span class="badge">No fixada</span>
                    @endif
                </td>
                <td>
                    <a class="btn btn-secondary" href="{{ route('slides.edit', $slide) }}">Editar</a>

                    <form action="{{ route('slides.destroy', $slide) }}" method="POST" style="display:inline">
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
                <td colspan="5">Encara no hi ha diapositives manuals.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection



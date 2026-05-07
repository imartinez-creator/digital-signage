<label for="name">Nom de la pantalla</label>
<input
    type="text"
    id="name"
    name="name"
    value="{{ old('name', $screen->name) }}"
    placeholder="Pantalla Principal Edifici H"
    required
>

<label for="slug">Identificador únic</label>
<input
    type="text"
    id="slug"
    name="slug"
    value="{{ old('slug', $screen->slug) }}"
    placeholder="edifici-h-principal"
    required
>

<label for="content_order">Ordre del contingut</label>
<select id="content_order" name="content_order" required>
    <option value="manual_first" @selected(old('content_order', $screen->content_order) === 'manual_first')>
        Primer contingut manual i després notícies web
    </option>
    <option value="web_first" @selected(old('content_order', $screen->content_order) === 'web_first')>
        Primer notícies web i després contingut manual
    </option>
</select>

<label>
    <input
        type="checkbox"
        name="is_blocked"
        value="1"
        @checked(old('is_blocked', $screen->is_blocked ?? false))
    >
    Bloquejar pantalla
</label>

<label for="blocked_message">Missatge quan la pantalla està bloquejada</label>
<input
    type="text"
    id="blocked_message"
    name="blocked_message"
    value="{{ old('blocked_message', $screen->blocked_message) }}"
    placeholder="Pantalla fora de servei"
>

<label>Diapositives manuals assignades a aquesta pantalla</label>

@forelse($slides as $slide)
    <label style="font-weight: normal;">
        <input
            type="checkbox"
            name="manual_slides[]"
            value="{{ $slide->id }}"
            @checked(in_array($slide->id, old('manual_slides', $selectedSlides)))
        >
        {{ $slide->title }}
        @if($slide->is_pinned)
            — FIXADA
        @endif
        @if(!$slide->is_active)
            — INACTIVA
        @endif
    </label>
@empty
    <p>No hi ha diapositives manuals creades.</p>
@endforelse

<p>
    <button class="btn" type="submit">Desar</button>
    <a class="btn btn-secondary" href="{{ route('screens.index') }}">Cancel·lar</a>
</p>


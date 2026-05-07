<label for="title">Títol</label>
<input
    type="text"
    id="title"
    name="title"
    value="{{ old('title', $slide->title) }}"
    required
>

<label for="body">Cos del missatge</label>
<textarea id="body" name="body" required>{{ old('body', $slide->body) }}</textarea>

<label for="image_url">URL de la imatge opcional</label>
<input
    type="url"
    id="image_url"
    name="image_url"
    value="{{ old('image_url', $slide->image_url) }}"
    placeholder="https://exemple.com/imatge.jpg"
>

<label for="sort_order">Ordre</label>
<input
    type="number"
    id="sort_order"
    name="sort_order"
    value="{{ old('sort_order', $slide->sort_order ?? 0) }}"
    min="0"
    required
>

<label>
    <input
        type="checkbox"
        name="is_active"
        value="1"
        @checked(old('is_active', $slide->is_active ?? true))
    >
    Diapositiva activa
</label>

<label>
    <input
        type="checkbox"
        name="is_pinned"
        value="1"
        @checked(old('is_pinned', $slide->is_pinned ?? false))
    >
    Fixar aquesta entrada
</label>

<p>
    <button class="btn" type="submit">Desar</button>
    <a class="btn btn-secondary" href="{{ route('slides.index') }}">Cancel·lar</a>
</p>



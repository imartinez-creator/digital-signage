<?php

namespace App\Http\Controllers;

use App\Models\ManualSlide;
use App\Models\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ScreenController extends Controller
{
    public function index()
    {
        $screens = Screen::with('manualSlides')
            ->orderBy('name')
            ->get();

        return view('screens.index', compact('screens'));
    }

    public function create()
    {
        $screen = new Screen([
            'content_order' => 'manual_first',
            'blocked_message' => 'Pantalla fora de servei',
        ]);

        $slides = ManualSlide::orderBy('sort_order')->get();
        $selectedSlides = [];

        return view('screens.create', compact('screen', 'slides', 'selectedSlides'));
    }

    public function store(Request $request)
    {
        $data = $this->validateScreen($request);

        $data['slug'] = Str::slug($data['slug']);
        $data['is_blocked'] = $request->has('is_blocked');

        $screen = Screen::create($data);
        $screen->manualSlides()->sync($request->input('manual_slides', []));

        return redirect()
            ->route('screens.index')
            ->with('success', 'Pantalla creada correctament.');
    }

    public function show(Screen $screen)
    {
        return redirect()->route('screens.edit', $screen);
    }

    public function edit(Screen $screen)
    {
        $slides = ManualSlide::orderBy('sort_order')->get();

        $selectedSlides = $screen->manualSlides()
            ->pluck('manual_slides.id')
            ->toArray();

        return view('screens.edit', compact('screen', 'slides', 'selectedSlides'));
    }

    public function update(Request $request, Screen $screen)
    {
        $data = $this->validateScreen($request, $screen);

        $data['slug'] = Str::slug($data['slug']);
        $data['is_blocked'] = $request->has('is_blocked');

        $screen->update($data);
        $screen->manualSlides()->sync($request->input('manual_slides', []));

        return redirect()
            ->route('screens.index')
            ->with('success', 'Pantalla actualitzada correctament.');
    }

    public function destroy(Screen $screen)
    {
        $screen->delete();

        return redirect()
            ->route('screens.index')
            ->with('success', 'Pantalla eliminada correctament.');
    }

    private function validateScreen(Request $request, ?Screen $screen = null): array
    {
        $screenId = $screen?->id;

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('screens', 'slug')->ignore($screenId),
            ],
            'blocked_message' => ['nullable', 'string', 'max:255'],
            'content_order' => ['required', Rule::in(['manual_first', 'web_first'])],
            'manual_slides' => ['array'],
            'manual_slides.*' => ['exists:manual_slides,id'],
        ]);
    }
}



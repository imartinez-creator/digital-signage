<?php

namespace App\Http\Controllers;

use App\Models\ManualSlide;
use Illuminate\Http\Request;

class ManualSlideController extends Controller
{
    public function index()
    {
        $slides = ManualSlide::orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('slides.index', compact('slides'));
    }

    public function create()
    {
        $slide = new ManualSlide();

        return view('slides.create', compact('slide'));
    }

    public function store(Request $request)
    {
        $data = $this->validateSlide($request);

        $data['is_active'] = $request->has('is_active');
        $data['is_pinned'] = $request->has('is_pinned');

        ManualSlide::create($data);

        return redirect()
            ->route('slides.index')
            ->with('success', 'Diapositiva creada correctament.');
    }

    public function show(ManualSlide $slide)
    {
        return redirect()->route('slides.edit', $slide);
    }

    public function edit(ManualSlide $slide)
    {
        return view('slides.edit', compact('slide'));
    }

    public function update(Request $request, ManualSlide $slide)
    {
        $data = $this->validateSlide($request);

        $data['is_active'] = $request->has('is_active');
        $data['is_pinned'] = $request->has('is_pinned');

        $slide->update($data);

        return redirect()
            ->route('slides.index')
            ->with('success', 'Diapositiva actualitzada correctament.');
    }

    public function destroy(ManualSlide $slide)
    {
        $slide->delete();

        return redirect()
            ->route('slides.index')
            ->with('success', 'Diapositiva eliminada correctament.');
    }

    private function validateSlide(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'image_url' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);
    }
}



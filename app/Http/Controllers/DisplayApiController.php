<?php

namespace App\Http\Controllers;

use App\Models\Screen;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DisplayApiController extends Controller
{
    public function show(Screen $screen)
    {
        if ($screen->is_blocked) {
            return response()->json([
                'screen' => [
                    'name' => $screen->name,
                    'slug' => $screen->slug,
                ],
                'blocked' => true,
                'message' => $screen->blocked_message ?: 'Pantalla fora de servei',
                'slides' => [],
            ]);
        }

        $manualSlides = $screen->manualSlides()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $pinnedSlides = $manualSlides
            ->where('is_pinned', true)
            ->values();

        if ($pinnedSlides->isNotEmpty()) {
            return response()->json([
                'screen' => [
                    'name' => $screen->name,
                    'slug' => $screen->slug,
                ],
                'blocked' => false,
                'mode' => 'pinned',
                'slides' => $this->formatManualSlides($pinnedSlides),
            ]);
        }

        $webSlides = $this->getWebSlides();
        $manualFormatted = $this->formatManualSlides($manualSlides);

        if ($screen->content_order === 'web_first') {
            $slides = array_merge($webSlides, $manualFormatted);
        } else {
            $slides = array_merge($manualFormatted, $webSlides);
        }

        return response()->json([
            'screen' => [
                'name' => $screen->name,
                'slug' => $screen->slug,
            ],
            'blocked' => false,
            'mode' => $screen->content_order,
            'slides' => $slides,
        ]);
    }

    private function formatManualSlides($slides): array
    {
        return $slides->map(function ($slide) {
            return [
                'type' => 'manual',
                'title' => $slide->title,
                'body' => $slide->body,
                'image_url' => $slide->image_url,
                'url' => null,
                'date' => $slide->created_at?->toDateTimeString(),
            ];
        })->toArray();
    }

    private function getWebSlides(): array
    {
        try {
            $response = Http::timeout(5)->get(
                'https://agora.xtec.cat/ies-mollerussa/wp-json/wp/v2/posts?per_page=5'
            );

            if (!$response->successful()) {
                return [];
            }

            return collect($response->json())
                ->map(function ($post) {
                    return [
                        'type' => 'web',
                        'title' => html_entity_decode(strip_tags($post['title']['rendered'] ?? 'Sense títol')),
                        'body' => Str::limit(
                            html_entity_decode(strip_tags($post['excerpt']['rendered'] ?? '')),
                            300
                        ),
                        'image_url' => null,
                        'url' => $post['link'] ?? null,
                        'date' => $post['date'] ?? null,
                    ];
                })
                ->toArray();

        } catch (\Throwable $e) {
            return [];
        }
    }
}



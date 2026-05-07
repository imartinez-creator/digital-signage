<?php

namespace Database\Seeders;

use App\Models\ManualSlide;
use App\Models\Screen;
use Illuminate\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    public function run(): void
    {
        $entrada1 = ManualSlide::create([
            'title' => 'Benvinguts a l’Edifici H',
            'body' => 'Aquest és un missatge manual creat des del gestor de cartelleria digital.',
            'image_url' => null,
            'is_active' => true,
            'is_pinned' => false,
            'sort_order' => 1,
        ]);

        $entrada2 = ManualSlide::create([
            'title' => 'Recordatori important',
            'body' => 'Reviseu els horaris i les comunicacions del centre.',
            'image_url' => null,
            'is_active' => true,
            'is_pinned' => false,
            'sort_order' => 2,
        ]);

        $pantalla = Screen::create([
            'name' => 'Pantalla Principal Edifici H',
            'slug' => 'edifici-h-principal',
            'is_blocked' => false,
            'blocked_message' => 'Pantalla fora de servei',
            'content_order' => 'manual_first',
        ]);

        $pantalla->manualSlides()->sync([
            $entrada1->id,
            $entrada2->id,
        ]);
    }
}
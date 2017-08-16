<?php

use App\Street;
use Illuminate\Database\Seeder;

class StreetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $streets = collect([
            [
                'slug' => "avenida-del-cid",
                'name' => 'Avenida del Cid',
            ],
            [
                'slug' => "camino-de-picanya",
                'name' => 'Camino Nuevo de Picaña',
            ],
            [
                'slug' => "avenida-de-los-hermanos-maristas",
                'name' => 'Avenida de los Hermanos Maristas',
            ],
            [
                'slug' => "avenida-de-los-hermanos-machado",
                'name' => 'Avenida de los Hermanos Machado',
            ],
            [
                'slug' => "avenida-pio-baroja",
                'name' => 'Avenida de Pío Baroja',
            ],
            [
                'slug' => "avenida-ausias-march",
                'name' => 'Avenida de Ausiàs March',
            ],
            [
                'slug' => "avenida-del-mestre-rodrigo",
                'name' => 'Avenida del Maestro Rodrigo',
            ],
            [
                'slug' => "avenida-de-manuel-de-falla",
                'name' => 'Avenida Manuel de Falla',
            ],
            [
                'slug' => "avenida-del-general-aviles",
                'name' => 'Avenida del General Avilés',
            ],
            [
                'slug' => "paseo-de-la-pechina",
                'name' => 'Paseo de la Pechina',
            ],
            [
                'slug' => "antonio-ferrandis",
                'name' => 'Avenida del Actor Antonio Ferrandis',
            ],
            [
                'slug' => "avenida-dels-tarongers",
                'name' => 'Avinguda dels Tarongers',
            ],
            [
                'slug' => "avenida-de-las-tres-cruces",
                'name' => 'Avenida de las Tres Cruces',
            ],
            [
                'slug' => "carretera-en-corts",
                'name' => 'Carrera de la Font d\'en Corts',
            ],
            [
                'slug' => "calle-de-luis-peixo",
                'name' => 'Carrer de Luís Peixó',
            ],
            [
                'slug' => "calle-blanquerias",
                'name' => 'Calle de la Blanqueria',
            ],
            [
                'slug' => "avenida-de-perez-galdos",
                'name' => 'Avenida de Pérez Galdós',
            ],
            [
                'slug' => "avenida-fernando-abril-martorell",
                'name' => 'Avinguda de Fernando Abril Martorell',
            ],
            [
                'slug' => "calle-guillem-castro",
                'name' => 'Calle de Guillem Castro',
            ],
            [
                'slug' => "calle-del-ingeniero-fausto-elio",
                'name' => 'Calle del Ingeniero Fausto Elio',
            ],
            [
                'slug' => "avenida-de-blasco-ibanez",
                'name' => 'Avenida de Blasco Ibáñez',
            ],
        ])->each(function ($street) {
            Street::create([
                'slug' => $street['slug'],
                'name' => $street['name']
            ]);
        });
    }
}

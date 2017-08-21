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
                'point' => [39.4687254, -0.399591],
            ],
            [
                'slug' => "camino-de-picanya",
                'name' => 'Camino Nuevo de Picaña',
                'point' => [39.4548759, -0.406178],
            ],
            [
                'slug' => "avenida-de-los-hermanos-maristas",
                'name' => 'Avenida de los Hermanos Maristas',
                'point' => [39.4517735, -0.367219],
            ],
            [
                'slug' => "avenida-de-los-hermanos-machado",
                'name' => 'Avenida de los Hermanos Machado',
                'point' => [39.4967059, -0.365505],
            ],
            [
                'slug' => "avenida-pio-baroja",
                'name' => 'Avenida de Pío Baroja',
                'point' => [39.4768292, -0.406411],
            ],
            [
                'slug' => "avenida-ausias-march",
                'name' => 'Avenida de Ausiàs March',
                'point' => [39.4488449, -0.370129],
            ],
            [
                'slug' => "avenida-del-mestre-rodrigo",
                'name' => 'Avenida del Maestro Rodrigo',
                'point' => [39.4820091, -0.400792],
            ],
            [
                'slug' => "avenida-de-manuel-de-falla",
                'name' => 'Avenida Manuel de Falla',
                'point' => [39.4758023, -0.399185],
            ],
            [
                'slug' => "avenida-del-general-aviles",
                'name' => 'Avenida del General Avilés',
                'point' => [39.4847996, -0.398453],
            ],
            [
                'slug' => "paseo-de-la-pechina",
                'name' => 'Paseo de la Pechina',
                'point' => [39.4780507, -0.387877],
            ],
            [
                'slug' => "antonio-ferrandis",
                'name' => 'Avenida del Actor Antonio Ferrandis',
                'point' => [39.4517114, -0.355635],
            ],
            [
                'slug' => "avenida-dels-tarongers",
                'name' => 'Avinguda dels Tarongers',
                'point' => [39.4803446, -0.347038],
            ],
            [
                'slug' => "avenida-de-las-tres-cruces",
                'name' => 'Avenida de las Tres Cruces',
                'point' => [39.4605792, -0.404067],
            ],
            [
                'slug' => "carretera-en-corts",
                'name' => 'Carrera de la Font d\'en Corts',
                'point' => [39.4487538,-0.360819],
            ],
            [
                'slug' => "calle-de-luis-peixo",
                'name' => 'Carrer de Luís Peixó',
                'point' => [39.4738106, -0.33389],
            ],
            [
                'slug' => "calle-blanquerias",
                'name' => 'Calle de la Blanqueria',
                'point' => [39.4807835, -0.378361],
            ],
            [
                'slug' => "avenida-de-perez-galdos",
                'name' => 'Avenida de Pérez Galdós',
                'point' => [39.4706842, -0.3927],
            ],
            [
                'slug' => "avenida-fernando-abril-martorell",
                'name' => 'Avinguda de Fernando Abril Martorell',
                'point' => [39.4449386, -0.37408],
            ],
            [
                'slug' => "calle-guillem-castro",
                'name' => 'Calle de Guillem Castro',
                'point' => [39.4694543, -0.382223],
            ],
            [
                'slug' => "calle-del-ingeniero-fausto-elio",
                'name' => 'Calle del Ingeniero Fausto Elio',
                'point' => [39.4817234, -0.332275],
            ],
            [
                'slug' => "avenida-de-blasco-ibanez",
                'name' => 'Avenida de Blasco Ibáñez',
                'point' => [39.4776284, -0.360377],
            ],
        ])->each(function ($street) {
            Street::create([
                'slug' => $street['slug'],
                'name' => $street['name'],
                'point' => $street['point'],
            ]);
        });
    }
}


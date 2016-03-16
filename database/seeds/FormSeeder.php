<?php

use Illuminate\Database\Seeder;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $acum = 0;

        for ( $i = 1; $i<=3; $i++):
			DB::table('forms')->insert([
				'id'       => $i,
                'name'     => $faker->words($nb = 1, $asText = true),
	            'user_id'  => $faker->numberBetween($min = 1, $max = 3),
	        ]);

			$nFields = $faker->numberBetween($min = 3, $max = 6);

			for ( $j = 1; $j<=$nFields; $j++ ):
				DB::table('field_descriptors')->insert([
					'id'       => $acum + $j,
					'form_id'  => $i,
		            'position' => $j,
		            'label'    => $faker->words($nb = 3, $asText = true),
		            'question' => $faker->words($nb = 3, $asText = true),
		            'type'     => $faker->randomElements(
                        ['TEXT',           // area de texto          --> text_values
                        'STRING',          // campo de texto         --> string_values
                        'NUMBER',          // campo de numero        --> float_values
                        'DATE',            // campo de fecha         --> date_values
                        'RATING',          // campo de rating        --> integer_values
                        'LOCATION',        // campo de GPS           --> location_values
                        'PHOTO',           // capturar foto          --> blob_values
                        'CANVAS_PHOTO',    // capturar y editar foto --> blob_values
                        'OPTION',          // seleccionar opcion     --> integer_values
                                           // opciones posibles      --> option_types
                        'QR_CODE'          // leer codigo QR         --> text_values
                        ], $count = 1)[0],
		        ]);
			endfor;

            $acum += $j;

        endfor;
    }
}

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
	            'user_id'  => $faker->numberBetween($min = 1, $max = 3),
	        ]);

			$nFields = $faker->numberBetween($min = 3, $max = 6);

			for ( $j = 1; $j<=$nFields; $j++ ):
				DB::table('field_descriptors')->insert([
					'id'       => $acum + $j,
					'form_id'  => $i,
		            'number'   => $j,
		            'position' => $j,
		            'label'    => $faker->words($nb = 3, $asText = true),
		            'question' => $faker->words($nb = 3, $asText = true),
		            'type'     => $faker->randomElements([
                        'TEXT',
                        'INT',
                        'FLOAT',
                        'TIMESTAMP',
                        'RATING',   // TINYINT
                        'LOCATION', // Tabla compuesta con dos float
                        'BLOB',     // Archivo
                        'OPTION',   // En otra tabla se encuentra las opciones posibles
                		], $count = 1)[0],
		        ]);
			endfor;

            $acum += $j;

        endfor;
    }
}

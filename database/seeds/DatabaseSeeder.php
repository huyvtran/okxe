<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $faker = Faker::create();
    	foreach (range(1,10) as $index) {
	        DB::table('item')->insert([
                'title' => $faker->name,
                'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
                'id_model' =>$faker->numberBetween(1,69),
                'id_province' =>$faker->numberBetween(1,96),
                'id_brand' =>$faker->numberBetween(1,79),
                'id_user' =>$faker->numberBetween(1,7),
	            'created_at' => $faker->dateTimeBetween($startDate = '-1 months', $endDate = 'now'),
                'status' => $faker->randomElement(array('New', 'Active', 'Inactive')),
	        ]);
        }
    }
}

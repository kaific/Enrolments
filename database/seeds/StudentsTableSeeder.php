<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use App\Student;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for ($i = 0; $i != 50; $i++) {
            $s = new Student();
            $s->name = $faker->name;
            $s->address = $faker->numberBetween(1, 100) . ' ' . $faker->streetName . ', ' . $faker->city;
            $s->phone = $faker->numerify("0##-#######");
            $s->email = $faker->email;
            $s->save();
        }
    }
}

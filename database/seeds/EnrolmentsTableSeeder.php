<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use App\Course;
use App\Student;
use App\Enrolment;

class EnrolmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = Course::all();
        $students = Student::all();
        $statusArray = ['registered', 'attending', 'deferred', 'withdrawn'];
        $faker = Factory::create();
        for ($i = 0; $i != 200; $i++) {
          $c = $courses->random();
          $s = $students->random();

          $dateTime = $faker->dateTimeBetween('-3 months', 'now');

          $e = new Enrolment();
          $e->course_id = $c->id;
          $e->student_id = $s->id;
          $e->date = $dateTime->format('Y-m-d');
          $e->time = $dateTime->format('H:i');
          $e->status = $statusArray[array_rand($statusArray)];
          $e->save();
        }
    }
}

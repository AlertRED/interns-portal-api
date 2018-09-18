<?php

use Illuminate\Database\Seeder;
use App\Models\Internship\InternshipCourse;

class InternshipCoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = ["FrontEnd2", "BackEnd1"];

        foreach ($courses as $course) {
            InternshipCourse::firstOrCreate(["course" => $course]);
        }
    }
}

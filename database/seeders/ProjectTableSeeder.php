<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Models\Project;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        for ($i = 0; $i < 3; $i++) {
            $project = new Project();
            $project->title = $faker->sentence(5);
            $project->slug = Str::slug($project->title, '-');
            $project->content = $faker->text(200);
            $project->save();
        }
    }
}
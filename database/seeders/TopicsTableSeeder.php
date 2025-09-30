<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\User;
class TopicsTableSeeder extends Seeder
{
    public function run()
    {
      Topic::factory()->count(100)->create();

    }
}


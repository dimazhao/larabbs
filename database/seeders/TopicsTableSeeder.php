<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\User;
class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        // 在 TopicsTableSeeder 的 run 方法中
    Topic::factory()->create([
    'user_id' => User::inRandomOrder()->first()->id, // 从用户中随机选一个作为话题作者
    // 其他字段...
]);
    }
}


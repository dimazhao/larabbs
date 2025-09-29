<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::factory()->count(10)->create();

        //
        $user = User::find(1);
        $user->name="dima";
        $user->email= "dima@dima.com";
        $user->avatar= "https://img2.woyaogexing.com/2025/04/21/8204ce806fac8c8aa814d49185ec0e09.jpg";
        $user->save();

    }
}

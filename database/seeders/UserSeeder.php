<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for ($i = 0; $i < 20; $i++)
        {
            User::create([
                'name' => Str::random(10),
                'email' => Str::random(10).'@gmail.com',
                'last_login' => Carbon::now()->toDateTimeString(),
                'authorized' => Carbon::now()->toDateTimeString(),
                'user_type_id' => UserType::all()->random()->id
            ]);
        }

    }
}

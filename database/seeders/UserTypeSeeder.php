<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $arrType = ['Admin', 'Unauthorized', 'Pharmacist', 'Nurse', 'Registrar', 'Doctor'];
        for($i = 0; $i < count($arrType); $i++)
        {
            UserType::create(['type_name' => $arrType[$i]]);
        }

    }
}

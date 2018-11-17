<?php

use Illuminate\Database\Seeder;
use App\UserType;
use Carbon\Carbon;

class UsersTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


    	   UserType::insert([
                'user_type' => 'hr_manager',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now()
        ]);

	        UserType::insert([
                'user_type' => 'job_moderator',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now()
	        ]);
	        
    }
}

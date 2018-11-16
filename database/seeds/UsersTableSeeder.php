<?php

use Illuminate\Database\Seeder;
use App\User;
use App\UserType;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        	
         $phones = factory(User::class, 2)->create([
            'user_type' => $this->getRandomUserType()
        ]);

    }


    public function getRandomUserType()
    {
    	$user_type = UserType::inRandomOrder()->first();
    	return $user_type->id;
    }
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{

    public $table = 'users_types';

    protected $guarded = ['id'];


    public function user()
    {
    	return $this->hasOne(User::class);
    }


}

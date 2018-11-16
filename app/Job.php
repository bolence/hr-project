<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    
    protected $guarded = ['id'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


}

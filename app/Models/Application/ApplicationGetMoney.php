<?php

namespace App\Models\Application;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ApplicationGetMoney extends Model
{
    protected $table ="application_users";


    public function sender(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}

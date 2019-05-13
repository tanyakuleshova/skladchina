<?php

namespace App\Models\Billing;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserAddition extends Model
{
    protected   $table='users_additions';

    protected   $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}

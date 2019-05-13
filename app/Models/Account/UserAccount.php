<?php

namespace App\Models\Account;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    protected  $table="user_account";

    protected   $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}

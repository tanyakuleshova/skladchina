<?php

namespace App\Models\Account;

use App\Admin;
use Illuminate\Database\Eloquent\Model;

class AdminAccount extends Model
{
    protected  $table="admin_account";

    protected   $guarded = ['id'];

    public function admin(){
        return $this->belongsTo(Admin::class,'admin_id','id');
    }
}

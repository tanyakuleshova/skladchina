<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Models\Billing\PayMethod;

class UserPayMethod extends Model
{
    protected  $table='user_pay_methods';
    
    protected  $guarded = ['id'];
    
  
  /**
    * Получить.
    * @return string
    */
  public function getNameAttribute()
  {
    return $this->temp_name;
  }
  
  /**
    * Установить 
    * @param  string  $value
    * @return void
    */
  public function setNameAttribute($value)
  {
    $this->attributes['temp_name'] = $value;
  }

    /**
     * Связь с пользователем
     */
    public function user(){
        return $this->belongsdTo(User::class,'user_id','id');
    }
    
    /**
     * Связь с платёжным методом
     */
    public function paymethod(){
        return $this->belongsdTo(PayMethod::class,'pay_method_id','id');
    }
}

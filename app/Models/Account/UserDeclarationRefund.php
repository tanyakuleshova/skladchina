<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Admin;
use App\Models\Billing\Currency;
use App\Models\Billing\Balance;
use App\Models\Billing\BalanceStatus;
use App\Models\Account\UserPayMethod;

class UserDeclarationRefund extends Model
{
    protected  $table='user_declaration_refund';
    
    protected  $guarded = ['id'];
    
  
  /**
    * Получить.
    * @return string
    */
  public function getDeclarationAttribute()
  {
    return $this->user_declaration_image;
  }
  
  /**
    * Установить 
    * @param  string  $value
    * @return void
    */
  public function setDeclarationAttribute($value)
  {
    $this->attributes['user_declaration_image'] = $value;
  }

    /**
     * Связь с пользователем
     */
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    
    /**
     * Связь с admin
     */
    public function admin(){
        return $this->belongsTo(Admin::class,'admin_id','id');
    }
    
    /**
     * Получаем валюту текущей операции
     */
    public function currency(){
        return $this->belongsTo(Currency::class,'currency_id','id');
    }
    
    /**
     * Обратная связь с таблицей баланса, получим одну запись или null
     */
    public function balance(){
        return $this->belongsTo(Balance::class,'balance_id','id');
    }
    
    /**
     * Получаем статус операции
     */
    public function status(){
        return $this->belongsTo(BalanceStatus::class,'status_id','id');
    }
    
    /**
     * Связь с платёжным реквезитом заявки
     */
    public function userpaymethod(){
        return $this->belongsTo(UserPayMethod::class,'user_pay_methods_id','id');
    }
    
    
    public function getIsPendingAttribute() {
        return $this->status_id == 1 ? \TRUE : \FALSE ;
    }
    
    public function getIsRejectedAttribute() {
        return $this->status_id == 2 ? \TRUE : \FALSE ;
    }
    
    public function getIsApprovedAttribute() {
        return $this->status_id == 3 ? \TRUE : \FALSE ;
    }
    
    
    ///////scope
    
    public function scopePending($query){
        return $query->where('status_id', 1);
    }
    
    public function scopeRejected($query){
        return $query->where('status_id', 2);
    }
    
    public function scopeApproved($query){
        return $query->where('status_id', 3);
    }
}

<?php

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Model;

class BalanceOperations extends Model
{
    protected  $table='balance_operations';
    
    protected  $guarded = ['id'];
    

  /**
    * Получить Название Операции Баланса.
    * @todo Заменить на мультиязычную поддержку через связи
    * @return string
    */
  public function getNameAttribute()
  {
    return $this->temp_name;
  }
  
  /**
    * Установить Название Операции Баланса
    * @todo Заменить на мультиязычную поддержку через связи
    * @param  string  $value
    * @return void
    */
  public function setNameAttribute($value)
  {
    $this->attributes['temp_name'] = $value;
  }
  
}

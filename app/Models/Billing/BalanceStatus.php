<?php

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Model;

class BalanceStatus extends Model
{
    protected  $table='balance_status';
    
    protected  $guarded = ['id'];
    

  /**
    * Получить Название Статуса Баланса.
    * @todo Заменить на мультиязычную поддержку через связи
    * @return string
    */
  public function getNameAttribute()
  {
    return $this->temp_name;
  }
  
  
  /**
    * Установить Название Статуса Баланса
    * @todo Заменить на мультиязычную поддержку через связи
    * @param  string  $value
    * @return void
    */
  public function setNameAttribute($value)
  {
    $this->attributes['temp_name'] = $value;
  }
}

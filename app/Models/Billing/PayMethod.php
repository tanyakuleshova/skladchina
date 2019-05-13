<?php

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PayMethod extends Model
{
    protected  $table='pay_methods';
    
    protected  $guarded = ['id'];
    
  /**
   * "Загружающий" метод модели.
   *
   * @return void
   */
  protected static function boot()
  {
    parent::boot();

    static::addGlobalScope('active', function (Builder $builder) {
      $builder->where('status', 1);
    });
  }
  
  
  /**
    * Получить Название Платёжного метода.
    * @todo Заменить на мультиязычную поддержку через связи
    * @return string
    */
  public function getNameAttribute()
  {
    return $this->temp_name;
  }
  
  /**
    * Установить Название Платёжного метода
    * @todo Заменить на мультиязычную поддержку через связи
    * @param  string  $value
    * @return void
    */
  public function setNameAttribute($value)
  {
    $this->attributes['temp_name'] = $value;
  }
  
  /**
    * Получить статус Платёжного метода.
    * @return bool
    */
  public function getActiveAttribute()
  {
    return $this->status? \TRUE : \FALSE;
  }
  
  /**
    * Установить статус Платёжного метода.
    * @return bool
    */
  public function setActiveAttribute($value)
  {
    $value = (int)$value<0?0:1;
    $this->attributes['status'] = $value;
  }
  
  
  

  
}

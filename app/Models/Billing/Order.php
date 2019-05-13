<?php

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Model;


use App\User;
use App\Models\Project\Project;
use App\Models\GiftProject\Gift;
use App\Models\Billing\Balance;
use App\Models\Account\UserGifts;






class Order extends Model
{
    protected  $table='orders';
    
    protected  $guarded = ['id'];
    
    /**
      * Атрибуты, которые должны быть преобразованы к базовым типам.
      *
      * @var array
      */
    protected $casts = [
        'userfields' => 'array',
        'history' => 'array',
    ];



    /**
     * Получаем пользователя
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
  
    /**
     * Получаем проект
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project() {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    
    
    /**
     * Связь с подарками проекта
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gift(){
        return $this->belongsTo(Gift::class,'project_gift_id','id');
    }
    
    /**
     * Связь с выбранным подарком, для записи в строке баланса
     */
    public function usergifts(){
        return $this->belongsTo(UserGifts::class,'id','order_id');
    }

    /**
     * Связь с балансом заказа
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function balance() {
        return $this->belongsTo(Balance::class, 'balance_id', 'id');
    }

    
    

    /**
     * Заготовка для выбора только подтверждённых/оплаченых заказов
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function scopeApproved($query){
        return $query->where('status_id', 3);
    }
    
    /**
     * Метод, accessor,
     * Статус подтверждённый заказов
     * @return bool
     */
    public function getIsApprovedAttribute() {
        return $this->status_id == 3? \TRUE : \FALSE;
    }
    
    /**
     * Метод, accessor,
     * Статус заказов ожидает подтверждения
     * @return bool
     */
    public function getIsPendingAttribute() {
        return $this->status_id == 1? \TRUE : \FALSE;
    }
    
    /**
     * Метод, accessor,
     * Статус заказов ожидает подтверждения
     * @return bool
     */
    public function getIsRejectedAttribute() {
        return $this->status_id == 2? \TRUE : \FALSE;
    }
}

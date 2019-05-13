<?php

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Models\Project\Project;
use App\Models\GiftProject\Gift;
use App\Models\Billing\Balance;


class Orderfail extends Model
{
    protected  $table='ordersfail';
    
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
     * Связь с балансом заказа
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function balance() {
        return $this->belongsTo(Balance::class, 'balance_id', 'id');
    }

}

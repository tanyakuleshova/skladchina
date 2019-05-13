<?php

namespace App\Models\Account;

use App\Models\GiftProject\Gift;
use App\User;
use App\Models\Project\Project;
use App\Models\Billing\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UserGifts extends Model
{
    use SoftDeletes;
    
    protected $table="user_gifts";
    
    protected  $guarded = ['id'];
    
    /**
      * Атрибуты, которые должны быть преобразованы к базовым типам.
      *
      * @var array
      */
    protected $casts = [
      'delivery' => 'array',
    ];
    
    /**
     * Связь с подарком
     */
    public function gift(){
        return $this->belongsTo(Gift::class,'gift_id','id');
    }
    
    
    /**
     * Связь с пользователем
     */
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    
    /**
     * Связь с проектом
     */
    public function project(){
        return $this->belongsTo(Project::class,'project_id','id');
    }
    
    public function order() {
        return $this->belongsTo(Order::class,'order_id','id');
    }
}

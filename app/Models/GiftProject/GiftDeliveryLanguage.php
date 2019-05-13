<?php

namespace App\Models\GiftProject;

use Illuminate\Database\Eloquent\Model;
use App;

class GiftDeliveryLanguage extends Model
{
    protected $table='gift_deliveries_language';
    protected  $guarded = ['id'];
    
    
    /**
     * Обратная связь с таблицей типов проекта
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function delivery(){
        return $this->belongsTo(GiftDelivery::class,'gift_deliveries_id','id');
    }
    
    /**
    * Заготовка запроса текущего языка.
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
   public function scopeCurrent($query, $local = null)
   {
        if(!$local) { $local = App::getLocale(); }
        return $query->where('language',$local);
   }
}

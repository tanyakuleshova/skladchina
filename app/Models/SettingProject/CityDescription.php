<?php

namespace App\Models\SettingProject;

use Illuminate\Database\Eloquent\Model;
use App;

class CityDescription extends Model
{
    protected  $table = 'list_city_description';

    protected  $guarded = ['id'];
    
    /**
     * Обратная связь с таблицей городов
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city(){
        return $this->belongsTo(City::class,'list_city_id','id');
    }
    
    /**
    * Заготовка запроса текущего языка.
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
   public function scopeCurrent($query)
   {
        $local = App::getLocale();
        return $query->where('language',$local);
   }
   
    /**
     * Метод, accessor, TODO
     * возвращает описание города на языке приложения / на первом найденном языке
     * @return CityDescription
     */
    public function getDescriptionAttribute() {
        $local = App::getLocale();
        $description = $this->where('language',$local)->first();
        if (!$description) {
            $description = $this->first();
        }
        return $description;
    }
}

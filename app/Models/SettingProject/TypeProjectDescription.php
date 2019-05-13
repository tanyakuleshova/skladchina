<?php

namespace App\Models\SettingProject;

use Illuminate\Database\Eloquent\Model;
use App;

class TypeProjectDescription extends Model
{
    protected $table='project_types_description';
    protected  $guarded = ['id'];
    
    
    /**
     * Обратная связь с таблицей типов проекта
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type(){
        return $this->belongsTo(TypeProject::class,'project_types_id','id');
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
}

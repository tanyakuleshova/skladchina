<?php

namespace App\Models\SettingProject;

use Illuminate\Database\Eloquent\Model;
use App;

class CategoryProjectDescription extends Model
{
    protected  $table = 'project_categories_description';

    protected  $guarded = ['id'];
    
    /**
     * Обратная связь с таблицей категорий
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(){
        return $this->belongsTo(CategoryProject::class,'project_categories_id','id');
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

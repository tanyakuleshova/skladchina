<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class StaticPageLanguage extends Model
{

    protected   $table='static_page_language';
    
    protected   $guarded = ['id'];
	
    /**
     * Обратная связь с таблицей страниц
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page(){
        return $this->belongsTo(StaticPage::class,'static_page_id','id');
    }
    
    /**
    * Заготовка запроса текущего языка.
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
   public function scopeCurrent($query, $local = null)
   {
        if (!$local) {$local = App::getLocale();}
        return $query->where('language',$local);
   }
}
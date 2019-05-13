<?php

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Model;
use App;

class CurrencyLanguage extends Model
{
    protected  $table='currency_language';
    
    protected  $guarded = ['id'];
    
    /**
    * Заготовка запроса текущего языка.
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
   public function scopeCurrent($query,$local)
   {
        if(!$local) {$local = App::getLocale();}
        return $query->where('language',$local);
   }

}

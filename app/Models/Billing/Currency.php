<?php

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Model;
use App;

class Currency extends Model
{
    protected  $table='currency';
    
    protected  $guarded = ['id'];
    
    protected  $currency_language_description = false;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['lang'];


    /**
     * Описание валюты на разных языках
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lang() {
        return $this->hasMany(CurrencyLanguage::class, 'currency_id', 'id');
    }
    
    /**
     * Описание валюты на основном языке, на первом доступном или NULL
     * @param string $language
     * @return CurrencyLanguage||null
     */
    public function langOf($language = null) {
        if ($this->currency_language_description || 
                $this->currency_language_description === null) 
                    { return $this->currency_language_description; }
        
        if (!$language) {$language = \App::getLocale();}
        
        $first = $this->lang->first(function ($value) use ($language){
            return $value->language == $language;
            });
            
        if ($first) { $first->OL = true;} else 
            {
                $first = $this->lang->first();
                if ($first) {  $first->OL = false;} 
            }
        
        $this->currency_language_description = $first;
        return $this->currency_language_description;
    }
    
    
    /**
     * Метод, accessor,
     * возвращает название валюты на языке приложения||на первом найденном языке
     * @return string
     */
    public function getNameAttribute() {
        
        if (!$this->relationLoaded('lang')) {
            $this->load(['lang'=>function($querry){
                        return $querry->current();
                    }]);
        } elseif($this->lang->count()>1) {
            $this->relations['lang'] = $this->lang->where('language',App::getLocale());
        }

        if ($this->lang->isEmpty()) { $this->load('lang'); }
            
        if ($this->lang->first()) { return $this->lang->first()->name; }
        
        return '--name currency-';
    }
    
    /**
     * Метод, accessor,
     * возвращает название валюты краткое на языке приложения||на первом найденном языке
     * @return string
     */
    public function getShortAttribute() {
        
        if (!$this->relationLoaded('lang')) {
            $this->load(['lang'=>function($querry){
                        return $querry->current();
                    }]);
        } elseif($this->lang->count()>1) {
            $this->relations['lang'] = $this->lang->where('language',App::getLocale());
        }

        if ($this->lang->isEmpty()) { $this->load('lang'); }
            
        if ($this->lang->first()) { return $this->lang->first()->short; }
        
        return '--short currency-';
    }
}

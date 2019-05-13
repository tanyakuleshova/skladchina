<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App;

class StaticPage extends Model
{
    protected $table='static_page';
    
    protected $guarded = [];
	
    /**
     * "Загружающий" метод модели.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('active', function (Builder $builder) {
          $builder->where('status', 1);
        });
    }
    
    /**
     * Связь с описанием на разных языках
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lang() {
        return $this->hasMany(StaticPageLanguage::class,'static_page_id','id');
    }
    
    
    /**
     * Метод, accessor,
     * возвращает name на языке приложения||на первом найденном языке||def_name
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
        
        return $this->def_name;
    }
    
    /**
     * Метод, accessor,
     * возвращает title на языке приложения||на первом найденном языке||def_name
     * @return string
     */
    public function getTitleAttribute() {
        
        if (!$this->relationLoaded('lang')) {
            $this->load(['lang'=>function($querry){
                        return $querry->current();
                    }]);
        } elseif($this->lang->count()>1) {
            $this->relations['lang'] = $this->lang->where('language',App::getLocale());
        }

        if ($this->lang->isEmpty()) { $this->load('lang'); }
            
        if ($this->lang->first()) { return $this->lang->first()->title; }
        
        return $this->def_name;
    }
    
    /**
     * Метод, accessor,
     * возвращает meta_description на языке приложения||на первом найденном языке||def_name
     * @return string
     */
    public function getMetaDescriptionAttribute() {
        
        if (!$this->relationLoaded('lang')) {
            $this->load(['lang'=>function($querry){
                        return $querry->current();
                    }]);
        } elseif($this->lang->count()>1) {
            $this->relations['lang'] = $this->lang->where('language',App::getLocale());
        }

        if ($this->lang->isEmpty()) { $this->load('lang'); }
            
        if ($this->lang->first()) { return $this->lang->first()->meta_description; }
        
        return $this->def_name;
    }
    
    /**
     * Метод, accessor,
     * возвращает meta_keywords на языке приложения||на первом найденном языке||def_name
     * @return string
     */
    public function getMetaKeywordsAttribute() {
        
        if (!$this->relationLoaded('lang')) {
            $this->load(['lang'=>function($querry){
                        return $querry->current();
                    }]);
        } elseif($this->lang->count()>1) {
            $this->relations['lang'] = $this->lang->where('language',App::getLocale());
        }

        if ($this->lang->isEmpty()) { $this->load('lang'); }
            
        if ($this->lang->first()) { return $this->lang->first()->meta_keywords; }
        
        return $this->def_name;
    }
    
    /**
     * Метод, accessor,
     * возвращает описание на языке приложения||на первом найденном языке||def_description
     * @return text
     */
    public function getDescriptionAttribute() {
        if (!$this->relationLoaded('lang')) {
            $this->load(['lang'=>function($querry){
                        return $querry->current();
                    }]);
        } elseif($this->lang->count()>1) {
            $this->relations['lang'] = $this->lang->where('language',App::getLocale());
        }

        if ($this->lang->isEmpty()) { $this->load('lang'); }
            
        if ($this->lang->first()) { return $this->lang->first()->description; }
        
        return $this->def_description;
    }

    /**
     * Метод, accessor,
     * возвращает статус
     * @return bool
     */
    public function getIsActiveAttribute() {
        return $this->status? \TRUE : \FALSE;
    }
    
}
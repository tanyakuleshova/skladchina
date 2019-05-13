<?php

namespace App\Models\SettingProject;

use Illuminate\Database\Eloquent\Model;

class StatusProject extends Model
{
    protected $table="project_status";

    protected  $guarded = ['id'];
    
    
    /**
     * Метод, accessor,
     * возвращает название название типа на языке приложения||на первом найденном языке
     * @todo Multilanguage table/model/relation
     * @return string
     */
    public function getNameAttribute() {
        return $this->attributes['name']?$this->attributes['name']:'--name--';
        
        
//        if (!$this->relationLoaded('lang')) {
//            $this->load(['lang'=>function($querry){
//                        return $querry->current();
//                    }]);
//        } elseif($this->lang->count()>1) {
//            $this->relations['lang'] = $this->lang->where('language',App::getLocale());
//        }
//
//        if ($this->lang->isEmpty()) { $this->load('lang'); }
//            
//        if ($this->lang->first()) { return $this->lang->first()->name; }
//        
//        return '--name--';
    }
    
    /**
     * Метод, accessor,
     * возвращает описание типа на языке приложения||на первом найденном языке
     * @todo Multilanguage table/model/relation
     * @return string
     */
    public function getDescriptionAttribute() {
        return $this->attributes['description']?$this->attributes['description']:'--description--';
        
//        if (!$this->relationLoaded('lang')) {
//            $this->load(['lang'=>function($querry){
//                        return $querry->current();
//                    }]);
//        } elseif($this->lang->count()>1) {
//            $this->relations['lang'] = $this->lang->where('language',App::getLocale());
//        }
//
//        if ($this->lang->isEmpty()) { $this->load('lang'); }
//            
//        if ($this->lang->first()) { return $this->lang->first()->description; }
//        
//        return '--description--';
    }
}

<?php

namespace App\Models\SettingProject;

use Illuminate\Database\Eloquent\Model;
use App;

class City extends Model
{
    protected  $table = 'list_city';

    protected  $guarded = ['id'];
    
    protected $current_language_description = null;
    
    /**
     * Метод, accessor,
     * возвращает описание города на языке приложения||на первом найденном языке
     * @return CityDescription
     */
    public function getDescriptionAttribute() {
        $local = App::getLocale();
        $description = CityDescription::where('list_city_id',  $this->id)
                ->where('language',$local)->first();
        if (!$description) {
            $description = CityDescription::where('list_city_id',  $this->id)
                    ->first();
        }
        return $description;
    }
    
    /**
     * Метод, accessor,
     * возвращает описание города на языке приложения||на первом найденном языке
     * @return CityDescription||false
     */
    public function getCldAttribute() {
        if ($this->current_language_description === false) { return false;}
        
        if (!array_key_exists('lang', $this->getRelations())) {
            $this->load('lang');
        }
        
        $local = App::getLocale();
        $this->current_language_description = $this->lang->first(function($value) use ($local) {
            return $value->language == $local;
        });
        
        if (!$this->current_language_description) { 
            $this->current_language_description = $this->lang->first(); }
        
        if (!$this->current_language_description) { $this->current_language_description = false; }
        
        return $this->current_language_description;
    }
    
    
    /**
     * Связь с описанием города на разных языках
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lang() {
        return $this->hasMany(CityDescription::class,'list_city_id','id');
    }
    
    /**
     * Связь с проектами в городе
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects() {
        return $this->hasMany(\App\Models\Project\Project::class,'city_id','id');
    }
    
//    public function getlistteamsAttribute() {
//        if (!array_key_exists('teams', $this->getRelations())) {
//            $this->load('teams');
//        }
//        $str='';
//        foreach ($this->teams as $team) {
//            $str.=$team->name.' ';
//        }
//        return $str;
//    }
    
    public function getNameAttribute() {
        if (!$this->relationLoaded('lang')) {
            $this->load(['lang'=>function($querry){
                        return $querry->current();
                    }]);
        } elseif(count($this->lang)>1) {
            $this->relations['lang'] = $this->lang->where('language',App::getLocale());
        }

        if (!count($this->lang)) { $this->load('lang'); }
            
        if (count($this->lang) && $this->lang->first()) { return $this->lang->first()->name; }
        
        return '--name--';
    }
    
}



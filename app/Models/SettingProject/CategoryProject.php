<?php

namespace App\Models\SettingProject;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

use App;

class CategoryProject extends Model
{
    //имя таблицы
    protected  $table = 'project_categories';

    //защита поля
    protected $guarded = ['id'];
    
    protected $current_language_description = null;


    /**
     * Метод, accessor,
     * возвращает описание категоии на языке приложения||на первом найденном языке
     * @return CategoryProjectDescription
     */
    public function getDescriptAttribute() {
        $local = App::getLocale();
        $description = CategoryProjectDescription::where('project_categories_id',  $this->id)
                ->where('language',$local)->first();
        if (!$description) {
            $description = CategoryProjectDescription::where('project_categories_id',  $this->id)
                    ->first();
        }
        return $description;
    }
    
    /**
     * Метод, accessor,
     * возвращает описание категоии на языке приложения||на первом найденном языке
     * @return CategoryProjectDescription||false
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
     * Связь с описанием категорий на разных языках
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lang() {
        return $this->hasMany(CategoryProjectDescription::class,'project_categories_id','id');
    }
    
    /**
     * Связь с описанием категорий на разных языках
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function langcur() {
        return $this->hasMany(CategoryProjectDescription::class,'project_categories_id','id')->current();
    }
    
    /**
     * Связь с проектами в категории
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects() {
        return $this->hasMany(\App\Models\Project\Project::class,'category_id','id');
    }
    
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
        
        return $this->attributes['name']?$this->attributes['name']:'--name--';
    }
}

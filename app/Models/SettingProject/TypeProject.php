<?php

namespace App\Models\SettingProject;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Project\Project;
use App;

class TypeProject extends Model
{
    protected $table='project_types';
    protected  $guarded = ['id'];
    
    protected $current_language_description = null;
    
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
        return $this->hasMany(TypeProjectDescription::class,'project_types_id','id');
    }
    

    /**
     * Связь с проектами данного типа
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects() {
        return $this->hasMany(Project::class,'type_id','id');
    }
    
    
    /**
     * Метод, accessor,
     * возвращает название название типа на языке приложения||на первом найденном языке
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
        
        return '--name--';
    }
    
    /**
     * Метод, accessor,
     * возвращает КРАТКОЕ описание типа  на языке приложения||на первом найденном языке
     * @return string
     */
    public function getShortDescriptionAttribute() {
        if (!$this->relationLoaded('lang')) {
            $this->load(['lang'=>function($querry){
                        return $querry->current();
                    }]);
        } elseif($this->lang->count()>1) {
            $this->relations['lang'] = $this->lang->where('language',App::getLocale());
        }

        if ($this->lang->isEmpty()) { $this->load('lang'); }
            
        if ($this->lang->first()) { return $this->lang->first()->short_description; }
        
        return '--short description--';
    }
    
    /**
     * Метод, accessor,
     * возвращает описание типа на языке приложения||на первом найденном языке
     * @return string
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
        
        return '--description--';
    }
    
    
    public function getIsActive() {
        return $this->status;
    }
}

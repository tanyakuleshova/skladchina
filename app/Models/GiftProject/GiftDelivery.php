<?php

namespace App\Models\GiftProject;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Project\Project;
use App;

class GiftDelivery extends Model
{
    protected $table='gift_deliveries';
    protected $guarded = ['id'];
    
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
        return $this->hasMany(GiftDeliveryLanguage::class,'gift_deliveries_id','id');
    }

    /**
     * Метод, accessor,
     * возвращает название название способа доставки на языке приложения||на первом найденном языке
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
     * возвращает описание способа доставки  на языке приложения||на первом найденном языке
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

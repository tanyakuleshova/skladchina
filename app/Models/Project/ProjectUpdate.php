<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Admin;
use App\Models\Project\Project;
use App\Models\GiftProject\Gift;
use App\Models\Billing\BalanceStatus;

use Illuminate\Support\Facades\Storage;

class ProjectUpdate extends Model
{
    use SoftDeletes;
    
    protected  $table='project_updates';
    
    protected  $guarded = ['id'];
    
    /**
    * Получить текст краткого описания
    * @return string
    */
    public function getShotDescAttribute()
    {
        return $this->up_shot_text;
    }
    
    /**
      * Установить текст краткого описания
      * @param  string  $value
      * @return void
      */
    public function setShotDescAttribute($value)
    {
        $this->attributes['up_shot_text'] = $value;
    }
    
    /**
      * Получить текст обновления
      * @return string
      */
    public function getTextAttribute()
    {
        return $this->up_text;
    }

    /**
      * Установить текст обновления
      * @param  string  $value
      * @return void
      */
    public function setTextAttribute($value)
    {
        $this->attributes['up_text'] = $value;
    }

    /**
      * Получить картинку обновления
      * @todo Заменить дефолтную картинку 
      * @return string
      */
    public function getImageAttribute()
    {
        if (Storage::disk('public')->exists($this->up_image)) {
            return Storage::url($this->up_image);
        } 
        
        return null;
    }

    /**
      * Установить картинку обновления
      * @param  string  $value
      * @return void
      */
    public function setImageAttribute($value)
    {
      $this->attributes['up_image'] = $value;
    }
    
  
    /**
     * Связь с project
     */
    public function project(){
        return $this->belongsTo(Project::class,'project_id','id');
    }
    
    /**
     * Связь с gift
     */
    public function gift(){
        return $this->belongsTo(Gift::class,'project_gift_id','id');
    }
  
    /**
     * Связь с пользователем
     */
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    
    /**
     * Связь с admin
     */
    public function admin(){
        return $this->belongsTo(Admin::class,'admin_id','id');
    }
    
    /**
     * Получаем статус операции
     */
    public function status(){
        return $this->belongsTo(BalanceStatus::class,'status_id','id');
    }
    

    
    public function getIsPendingAttribute() {
        return $this->status_id == 1 ? \TRUE : \FALSE ;
    }
    
    
    public function getIsApprovedAttribute() {
        return $this->status_id == 3 ? \TRUE : \FALSE ;
    }
    
    
    
    ///////scope
    
    public function scopePending($query){
        return $query->where('status_id', 1);
    }
    
    public function scopeRejected($query){
        return $query->where('status_id', 2);
    }
    
    public function scopeApproved($query){
        return $query->where('status_id', 3);
    }
}

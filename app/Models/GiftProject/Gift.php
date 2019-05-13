<?php

namespace App\Models\GiftProject;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\Storage;

use App\Models\Account\UserGifts;
use App\Models\Project\Project;
use Carbon\Carbon;

class Gift extends Model
{
    use SoftDeletes;
    
    protected $table='project_gifts';

    protected  $guarded = ['id'];
    
    private $usergiftscount;
    
    /**
     * Связь с project
     */
    public function project(){
        return $this->belongsTo(Project::class,'project_id','id');
    }
    
    /**
     * Связь с выбранными пользователями наградами
     */
    public function usergifts() {
        return $this->hasMany(UserGifts::class,'gift_id','id');
    }
    
    /**
     * Связь с типом доставки
     */
    public function delivery(){
        return $this->belongsTo(GiftDelivery::class,'delivery_id','id');
    }
    
    /**
     * Метод, accessor,
     * возвращает Название метода доставки для вознаграждения/подарка
     * @return string
     */
    public function getDeliveryMethodAttribute() {
        if (!$this->relationLoaded('delivery')) {
            $this->load('delivery');
        }

        if ($this->delivery) { return $this->delivery->name; }
        
        return '-delivery-';
    }
    
    /**
      * Получить дату доставки.
      *
      * @param  string  $value
      * @return string
      */
    public function getDeliveryDateAttribute($value)
    {
      if ($value=='0001-01-01') return '';  
      return Carbon::parse($value)->formatLocalized('%B %Y');
    }
    
    /**
      * Требуется доставка?.
      *
      * @param  string  $value
      * @return string
      */
    public function getIsDeliveryAttribute()
    {
      return $this->delivery_id !=  10;
    }
    
    /**
     * Метод, Считает количество выбранных пользователями наград
     * @return int
     */
    public function getUserGiftsCount() {
        if ($this->usergiftscount) { return $this->usergiftscount;}
        
        $this->usergiftscount = UserGifts::where('gift_id',$this->id)
                    ->where('status_id','!=',2)
                    ->sum('quantity');
        return $this->usergiftscount;
    }
    
    public function getUserIdGiftsCount($user_id = null) {
        if (!$user_id) { return $this->getUserGiftsCount(); }
        
        return UserGifts::where('gift_id',$this->id)
                    ->where('user_id',$user_id)
                    ->where('status_id','!=',2)
                    ->sum('quantity');
    }
    
    
    /**
     * Метод, accessor,
     * проверяет возможность заказать вознаграждение
     * @return bool
     */
    public function getLimitOutAttribute() {
        return ($this->limit != 0 && ( $this->getUserGiftsCount() >= $this->limit ));
    }
    
    public function getLimitOut($count = 1) {
        return ($this->limit != 0 && ( $this->getUserGiftsCount() + $count >= $this->limit ));
    }
    
    /**
     * Метод, accessor,
     * возвращает ссылку на картинку подарка или дефолтную
     * @return string
     */
    public function getImageAttribute() {
        if (Storage::disk('public')->exists($this->image_link)) {
            return Storage::url($this->image_link);
        }
        
        return 'images/defaults/gift.png';
    }
    
    /**
      * Есть картинка?
      *
      * @param  string  $value
      * @return string
      */
    public function getIsImageAttribute()
    {
      return Storage::disk('public')->exists($this->image_link);
    }
    
}

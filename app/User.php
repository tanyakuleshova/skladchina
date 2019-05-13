<?php

namespace App;

use App\Models\Billing\Balance;

use App\Models\Account\UserAccount;
use App\Models\Account\UserGifts;
use App\Models\Account\UserDeclarationRefund;
use App\Models\Project\Project;
use App\Models\Sponsored\Sponsors;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    protected  $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
    protected $my_balance;
    
    protected $my_sponsored_projects;

    protected $avatar_link;



    public function account(){
        return $this->hasOne(UserAccount::class,'user_id','id');
    }

    public function projects(){
        return $this->hasMany(Project::class,'user_id','id');
    }
    public function sponsored(){
        return $this->hasMany(Sponsors::class,'user_id','id');
    }
    public function gifts(){
        return $this->hasMany(UserGifts::class,'user_id','id');
    }
    
    public function balance() {
        return $this->hasMany(Balance::class,'user_id','id');
    }
    
    /**
     * Связь с таблицей заявок на возврат средств
     */
    public function refund() {
        return $this->hasMany(UserDeclarationRefund::class,'user_id','id');
    }
    
    /**
     * Метод, accessor,
     * возвращает ссылку на картинку профиля или дефолтную
     * @return string
     */
    public function getAvatarAttribute() {
        if (!$this->relationLoaded('account')) { $this->load('account'); }

        if (Storage::disk('public')->exists($this->account->avatar_link)) {
            return Storage::url($this->account->avatar_link);
        }
        
        return 'images/defaults/no-avatar.png';
    }
    
    public function isDefaultAvatar() {
        if (!$this->account->avatar_link) { return TRUE; }
        if (Storage::disk('public')->exists($this->account->avatar_link)) {
            return false;
        }
        return TRUE;
    }
    
    /**
     * Метод, accessor,
     * возвращает ссылку на город пользователя из профиля
     * @return string
     */
    public function getCityAttribute() {
        if (!$this->relationLoaded('account')) { $this->load('account'); }

        if (!$this->account){
            return '';
        } else {
            return $this->account->city_birth;
        }
        
    }
        
    
    /**
     * Метод, accessor,
     * возвращает ссылку на город пользователя из профиля
     * @return string
     */
    public function getFullNameAttribute() {
        return $this->name.($this->last_name?' '.$this->last_name:'');
    }
    
    

    /**
     * Метод получения пользователем списка поддержанных проектов
     * @param int $currency_id
     * @return Project
     */
    public function getSponsoredProjects($currency_id = null){
        if ($this->my_sponsored_projects) { return $this->my_sponsored_projects;}
        if (!$currency_id) { $currency_id = 1; }
        
        $this->my_sponsored_projects = Project::with(['balance'=>function($query) use ($currency_id){
            $query->where('user_id',  $this->id)
                    ->where('currency_id',$currency_id)
                    ->approved();
        }])->whereHas('balance',function($query) use ($currency_id){
            $query->where('user_id',  $this->id)
                    ->where('currency_id',$currency_id)
                    ->approved();
        })->get();
        return $this->my_sponsored_projects;
    }
       
    /**
     * Метод подсчёта баланса пользователя 
     * @param int $currency_id
     * @return int
     */
    public function getMyBalance($currency_id = null){
        if ($this->my_balance) { return $this->my_balance;}
        if (!$currency_id) { $currency_id = 1; }
        
        $this->my_balance = Balance::where('user_id',$this->id)
                    ->where('currency_id',$currency_id)
                    ->approved()                                                //только подтверждённый баланс
                    ->sum('summa');
        return $this->my_balance;
    }
    
    
    /**
     * Проверка наличия на балансе, пользователя требуемой суммы.
     * @param int $summa
     * @param int $currency_id
     * @return bool
     */
    public function checkmybalance($summa, $currency_id = null){
        return $this->getMyBalance($currency_id) >= abs((int)$summa);
    }
}

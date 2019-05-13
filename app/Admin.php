<?php

namespace App;

use App\Models\Account\AdminAccount;

use App\Models\Application\ApplicationGetMoney;
use App\Models\Project\Project;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\Storage;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $with = ['account'];
    
    public function account(){
        return $this->hasOne(AdminAccount::class,'admin_id','id');
    }
    
    /**
     * Метод, accessor,
     * возвращает ссылку на картинку профиля или дефолтную
     * @return string
     */
    public function getAvatarAttribute() {

        if (Storage::disk('public')->exists($this->account->avatar_link)) {
            return Storage::url($this->account->avatar_link);
        }
        
        return '/images/defaults/no-avatar.png';
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
     * возвращает Полное имя администратора
     * @return string
     */
    public function getFullNameAttribute() {
        return $this->name.' '.$this->account->last_name;
    }
    
    /**
     * Метод, accessor,
     * возвращает статус/текст админитратора
     * @return string
     */
    public function getStatusAttribute() {
        if ($this->account->status_id ==1) {
            return 'Включен';
        } else {
            return 'Отключен';
        }
    }
    
    /**
     * Метод, accessor,
     * проверяет статус администратора
     * @return string
     */
    public function getIsStatusAttribute() {
        return ($this->account->status_id === 1)? \TRUE : \FALSE;
    }
    
    
    /**
     * Метод, accessor,
     * проверяет  администратора? на ограничения менеджера
     * @return string
     */
    public function getIsAdminAttribute() {
        //return FALSE;
        if ($this->id == 1) { return \TRUE; }
        return ($this->account->manager === 1)? \FALSE: \TRUE ;
    }
    
    
    
    public function getCountProject(){
        if($this->getIsAdminAttribute()) {
            return Project::get()->count();
        } else {
            return Project::where('admin_id',$this->id)->get()->count();
        }
    }
    
    
    public function countAllProject() {
        if($this->getIsAdminAttribute()) {
            return Project::count();
        } else {
            return Project::where('admin_id',$this->id)->get()->count();
        }
    }
    
    public function countModProject() {
        if($this->getIsAdminAttribute()) {
            return Project::moderation()->count();
        } else {
            return Project::where('admin_id',$this->id)->moderation()->count();
        }
    }
    
    public function countCloseProject() {
        if($this->getIsAdminAttribute()) {
            return Project::allClosed()->count();
        } else {
            return Project::where('admin_id',$this->id)->allClosed()->count();
        }
    }
    
    public function getCountNewApplication(){
        $applications_count = ApplicationGetMoney::where('status',0)->get()->count();
        return $applications_count;
    }
    
    public function countPostProject() {
        if($this->getIsAdminAttribute()) {
            return Project::closedFMod()->count();
        } 
        return NULL;
    }
    
}

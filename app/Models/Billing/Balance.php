<?php

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Model;

use App\Models\Project\Project;
use App\Models\Account\UserGifts;
use App\Models\Billing\Order;

use App\User;
use App\Admin;


class Balance extends Model
{
    protected  $table='balance';
    
    protected  $guarded = ['id'];
    
    protected $with = ['user','admin','currency','type','status'];
    
    private $opgift;

    /**
     * Получаем пользователя
     * @return User
     */
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }


    /**
     * Получаем администратора поддтердившего текущюю операцию
     * @return Admin
     */
    public function admin(){
        return $this->belongsTo(Admin::class,'admin_id','id');
    }
    
    /**
     * Забавный метод
     * @return string
     */
    public function getAdminNameAttribute() {
        if ($this->admin) { return $this->admin->name; }            //просто имя админа
        if ($this->isApproved) { return '- auto -';}                // если нет админа, но операуия подтверждена
        return '';
    }
    
    /**
     * Описание валюты на разных языках
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaction() {
        return $this->hasMany(BalanceTransactions::class, 'balance_id', 'id');
    }
    
    
    /**
     * Получаем валюту текущей операции
     */
    public function currency(){
        return $this->belongsTo(Currency::class,'currency_id','id');
    }
    
    /**
     * Получаем тип операции
     */
    public function type(){
        return $this->belongsTo(BalanceOperations::class,'operation_type_id','id');
    }
    
    /**
     * Получаем статус операции
     */
    public function status(){
        return $this->belongsTo(BalanceStatus::class,'status_id','id');
    }
    
    /**
     * Связь с выбранным подарком, для записи в строке баланса
     */
    public function usergifts(){
        return $this->belongsTo(UserGifts::class,'id','balance_id');
    }
    
    /**
     * связь с заказом
     */
    public function order() {
        return $this->belongsTo(Order::class,'id','balance_id');
    }
    
    public function projects() {
        return $this->belongsToMany(\App\Models\Project\Project::class, 'balance_projects', 'balance_id', 'project_id');
    }
    
    
    /**
     * Получаем подарок операции
     * @return Currency
     */
    public function gift(){
        if ($this->opgift) { return $this->opgift;}
        if ($this->opgift === false) { return null; }
        
        if (!$this->relationLoaded('usergifts')) {
            $this->load('usergifts');
            }
            
        $this->opgift = $this->usergifts?$this->usergifts->gift:false;
        if ($this->opgift === false) { return null; }
        return $this->opgift;
    }
    
    public function scopeApproved($query){
        return $query->where('status_id', 3);
    }
    
    public function scopePending($query){
        return $query->where('status_id', 1);
    }
    
    /**
     * Метод, accessor,
     * Статус подтверждённый платёж
     * @return bool
     */
    public function getIsApprovedAttribute() {
        return $this->status_id == 3? \TRUE : \FALSE;
    }
    
    /**
     * Метод, accessor,
     * Статус платёж ожидает подтверждения
     * @return bool
     */
    public function getIsPendingAttribute() {
        return $this->status_id == 1? \TRUE : \FALSE;
    }
    
    /**
     * Метод, accessor,
     * Статус платёж ожидает подтверждения
     * @return bool
     */
    public function getIsRejectedAttribute() {
        return $this->status_id == 2? \TRUE : \FALSE;
    }
}

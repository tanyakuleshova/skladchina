<?php

namespace App\Models\Project;

use App\Models\GiftProject\Gift;
use App\Models\Account\UserGifts;
use App\Models\SettingProject\CategoryProject;
use App\Models\SettingProject\StatusProject;
use App\Models\SettingProject\TypeProject;
use App\Models\Comment;
use App\Models\Project\ProjectUpdate;
use App\User;
use App\Admin;


use App\Models\Billing\Order;
use App\Models\Billing\Orderfail;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App;

class Project extends Model
{
    use SoftDeletes;
    
    protected $table='project';

    protected  $guarded = ['id'];
    
    private $projectsumma;
    private $projectprocent;
    private $projectsponsored;
    private $projectsponsoredcount;
    private $projectusersumma = [];
    private $projectusergifts = [];

    /**
      * Атрибуты, которые должны быть преобразованы к базовым типам.
      *
      * @var array
      */
    protected $casts = [
      'valid_steps' => 'array',
    ];
        
    /**
     * Метод, accessor,
     * возвращает ссылку на картинку профиля или дефолтную
     * @return string
     */
    public function getPosterAttribute() {
        if (!$this->poster_link || trim($this->poster_link ) == '') { return 'images/defaults/no-project-poster.jpg'; }

        if (Storage::disk('public')->exists($this->poster_link)) {
            return Storage::url($this->poster_link);
        } elseif (file_exists(public_path($this->poster_link))) {
            return $this->poster_link;
        }
        return 'images/defaults/no-project-poster.jpg';
    }
    
       
    /**
     * Метод, accessor,
     * возвращает ссылку на картинку профиля или дефолтную
     * @return string
     */
    public function getSEOAttribute() {
        return str_slug($this->name, '-');
    }
    
    /**
     * Связь к видео проекта
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projectVideo(){
       return $this->hasOne(VideoProject::class,'project_id','id');
    }

    /**
     * Связь с подарками проекта
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projectGifts(){
        return $this->hasMany(Gift::class,'project_id','id');
    }

    /**
     * Связь с подарками проекта которые уже выбрали пользователи
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projectUserGifts(){
        return $this->hasMany(UserGifts::class,'project_id','id');
    }
    
    
    /**
     * Связь с заказами проекта
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(){
        return $this->hasMany(Order::class,'project_id','id');
    }
    
    /**
     * Связь с проваленными заказами проекта
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ordersfail(){
        return $this->hasMany(Orderfail::class,'project_id','id');
    }
    
    public function getFailOrderSponsored() {
        $fos = $this->ordersfail()->get();
        return $fos?$fos->unique('user_id'):NULL;
    }
    
    /**
     * Получаем количество спонсоров проваленного проекта
     * @return int
     */
    public function getFailOrderSponsoredCount() {
        $fos = $this->getFailOrderSponsored();
        return $fos?$fos->count():0;
    }
    
    /**
     * Получаем количество спонсоров проваленного проекта
     * @return int
     */
    public function getFailOrderSumm() {
        return $this->ordersfail()->sum('summa');
    }
    
    /**
     * Связь с таблице пользователей (к автору)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    
    /**
     * Связь с таблице админ
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin(){
        return $this->belongsTo(Admin::class,'admin_id','id');
    }
    
    /**
     * Связь с таблице города
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function projectCity(){
        return $this->belongsTo(\App\Models\SettingProject\City::class,'city_id','id');//TODO delete
    }
    /**
     * Связь с таблице города
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city(){
        return $this->belongsTo(\App\Models\SettingProject\City::class,'city_id','id');
    }

    /**
     * Свзяь с таблицей реквизитов
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function requisites(){
        return $this->hasOne(RequisitesProject::class,'project_id','id');
    }

    /**
     * Связь с таблицей категории
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoryProject(){
        return $this->belongsTo(CategoryProject::class,'category_id','id');     //TODO delete
    }
    public function category(){
        return $this->belongsTo(CategoryProject::class,'category_id','id'); 
    }

    
    
    public function status(){
        return $this->belongsTo(StatusProject::class,'status_id','id');
    }

    
    /**
     * Метод, accessor,
     * @todo переделать
     * @return bool
     */
    public function getStatusNameAttribute() {
        if (!$this->relationLoaded('status')) {
            $this->load(['status'=>function($querry){
                        //return $querry->current();
                    }]);
        } elseif(count($this->status)>1) {
            $this->relations['status'] = $this->status->where('language',App::getLocale());
        }

        if (empty($this->status)) { $this->load('status'); }
 
        if (!empty($this->status)) {  return $this->status->description; }
        
        return 'Сохранено';
    }

    /**
     * Связь с балансом проекта
     */
    public function balance() {
        return $this->belongsToMany(\App\Models\Billing\Balance::class, 'balance_projects', 'project_id', 'balance_id')->approved();
    }
    
    /**
     * Связь с типом проекта
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function type()
    {
     return $this->belongsTo(TypeProject::class,'type_id','id');
    }
    
    
    /**
     * Связь с комментариями к проекту
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function comments()
    {
     return $this->hasMany(Comment::class,'project_id','id');
    }
    
    /**
     * Связь с обновлениями к проекту
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function pupdates()
    {
     return $this->hasMany(ProjectUpdate::class,'project_id','id');
    }

    /**
     * Получаем сумму которую собрал проект
     * @return int
     */
    public function getActualSumm() {
        if($this->projectsumma) {return $this->projectsumma;}
        if (!$this->relationLoaded('balance')) {
            $this->load('balance');
            }
        $summa = $this->balance->sum('summa');
        if ($summa !== 0) {
            $summa = -$summa;
        }
        $this->projectsumma = $summa;
        return $this->projectsumma;
    }
    
    /**
     * 
     * @param int $user_id
     * @return int
     */
    public function getUserSumm($user_id = NULL) {
        if (!$user_id) { return $this->getActualSumm(); }
        
        if (isset($this->projectusersumma[$user_id])) { return $this->projectusersumma[$user_id]; }
            
        if (!$this->relationLoaded('balance')) {
            $this->load('balance');
            }
        
        $summa = $this->balance->where('user_id', $user_id)->sum('summa');
        if ($summa !== 0) {
            $summa = -$summa;
        }
        $this->projectusersumma[$user_id] = $summa;
        return $this->projectusersumma[$user_id];
    }
    
    /**
     * Связь с подарками проекта которые выбрал пользователь
     */
    public function getUserGifts($user_id = NULL){
        if (!$user_id) { return $this->projectUserGifts()->get(); }
        
        if (isset($this->projectusergifts[$user_id])) { return $this->projectusergifts[$user_id]; }
        
        $this->projectusergifts[$user_id] = $this->projectUserGifts()->where('user_id',$user_id)->get();

        return $this->projectusergifts[$user_id];
    }
    
    
    /**
     * Получаем процент собранной суммы от необходимой
     * @return int
     */
    public function projectProcent(){
        if($this->projectprocent) {return $this->projectprocent;}


        if($this->getActualSumm() != 0 and  $this->need_sum != 0){
            $res = ($this->getActualSumm()/$this->need_sum)*100;
        }else{
            $res = 0;
        }

       return $res;
    }
    
    
    public function getSponsored() {
        if($this->projectsponsored) {return $this->projectsponsored;}

        $usx3 = $this->balance()->orderBy('created_at')->get()->unique('user_id');
        
        $this->projectsponsored = collect();
        foreach ($usx3 as $u1) {
            $this->projectsponsored->push($u1->user);
        }
        return $this->projectsponsored;
    }
    
    
    /**
     * Получаем количество спонсоров проекта
     * @return int
     */
    public function getSposoredCount() {
        if($this->projectsponsoredcount) {return $this->projectsponsoredcount;}
        if (!$this->relationLoaded('balance')) {
            $this->load('balance');
            }
        $this->projectsponsoredcount = $this->balance->unique('user_id')->count();
        return $this->projectsponsoredcount;
    }
    
    
    
    
    /**
     * Заготовка для поиска по имени
     * @param type $query
     * @param type $search
     * @return type
     */
    public function scopeSearchOf($query,$search = '') {
        return $query->where('name','like','%'.$search.'%')->orWhere('short_desc','like','%'.$search.'%');
    }
    
    
    
    
    
    /**
    * Заготовка запроса для активных проектов.
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeActive($query, $boolean = 'and') {
        return $query->where('status_id', '=', 30, $boolean);
        
    }
    
    /**
     * Метод, accessor,
     * @return bool
     */
    public function getIsActiveAttribute() {
        return $this->status_id == 30? \TRUE : \FALSE;
    }
    
    
    /**
    * Заготовка запроса для проектов для страницы всех проектов.
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeAllActive($query, $boolean = 'and') {
        return $query->whereIn('status_id', [30,40, 50, 60], $boolean)->orderByRaw(\DB::raw("FIELD(status_id, 30,40,50,60)"));
    }
    
    
    /**
    * Заготовка запроса для проектов на модерации.
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeModeration($query, $boolean = 'and') {
        return $query->where('status_id', '=', 10, $boolean);
    }
       
    /**
     * Метод, accessor,
     * @return bool
     */
    public function getIsModerationAttribute() {
        return $this->status_id == 10? \TRUE : \FALSE;
    }
    
    /**
    * Заготовка запроса для проектов возможных к редактированию.
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeAllEdited($query) {
        return $query->whereNull('status_id')->orWhere('status_id', 20);
    }
    
    /**
     * Метод, accessor,
     * @return bool
     */
    public function getIsAllEditedAttribute() {
        return (!$this->status_id || $this->status_id == 20)? \TRUE : \FALSE;
    }
    
    
    
    /**
    * Заготовка запроса для проектов не прошедших модерацию, возможных к редактированию.
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeNotModeration($query, $boolean = 'and') {
        return $query->where('status_id', '=', 20 , $boolean);
    }
    
    /**
     * Метод, accessor,
     * @return bool
     */
    public function getIsNotModerationAttribute() {
        return ($this->status_id == 20)? \TRUE : \FALSE;
    }
    
    
    /**
    * Заготовка запроса для проектов закрытых по разным статусам.
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeAllClosed($query, $boolean = 'and') {
        return $query->whereIn('status_id', [40, 50, 60], $boolean);
    }
    
    
    /**
     * Метод, accessor,
     * @return bool
     */
    public function getIsAllClosedAttribute() {
        return ( in_array($this->status_id, [40,50,60]))? \TRUE : \FALSE;
    }
    
    
    /**
    * Заготовка запроса для проектов закрытых успешно.
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeClosedSuccess($query, $boolean = 'and') {
        return $query->where('status_id', '=', 40, $boolean);
    }
    
    /**
     * Метод, accessor,
     * @return bool
     */
    public function getIsClosedSuccessAttribute() {
        return $this->status_id == 40? \TRUE : \FALSE;
    }
    
    
    
    /**
    * Заготовка запроса для проектов закрытых NO успешно.
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeClosedFail($query, $boolean = 'and') {
        return $query->where('status_id', '=', 50, $boolean = 'and');
    }
    
    /**
     * Метод, accessor,
     * @return bool
     */
    public function getIsClosedFailAttribute() {
        return $this->status_id == 50? \TRUE : \FALSE;
    }
    
    /**
    * Заготовка запроса для проектов закрытых , до модерации.
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeClosedFMod($query, $boolean = 'and') {
        return $query->where('status_id', '=', 60, $boolean);
    }
    
    /**
     * Метод, accessor,
     * @return bool
     */
    public function getIsClosedModAttribute() {
        return $this->status_id == 60? \TRUE : \FALSE;
    }
    
    
    /**
     * Метод, accessor,дата окончания проекта
     * @return string
     */
    public function getStartDataAttribute() {
        if(!$this->date_start) return '';
        $local = (App::getLocale() == 'ua')?'uk':App::getLocale();
        if (App::getLocale() == 'ua') {
            Carbon::setLocale('uk_UA.utf8');
        } else {
            Carbon::setLocale('ru_RU.UTF-8');
        }
        return Carbon::parse($this->date_start)->formatLocalized('%d %B %Y');
    }
    
    /**
     * Метод, accessor,дата окончания проекта
     * @return string
     */
    public function getFinishDataAttribute() {
        if(!$this->date_finish) return '';
        $local = (App::getLocale() == 'ua')?'uk':App::getLocale();
        if (App::getLocale() == 'ua') {
            Carbon::setLocale('uk_UA.utf8');
        } else {
            Carbon::setLocale('ru_RU.UTF-8');
        }
        return Carbon::parse($this->date_finish)->formatLocalized('%d %B %Y');
    }
    
    public function getFinishData($clock = false) {
        if ($clock) { return Carbon::parse($this->date_finish)->diffInHours(); }
        
        return $this->getFinishDataAttribute();
    }
    

}

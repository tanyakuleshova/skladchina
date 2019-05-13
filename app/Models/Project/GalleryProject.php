<?php

namespace App\Models\Project;

use App\Models\Project\RequisitesProject;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class GalleryProject extends Model
{
    use SoftDeletes;
    
    protected $table='project_requisities_gallary';
    
    protected  $guarded = ['id'];
    
    
    public function prequisites(){
        return $this->belongsTo(RequisitesProject::class,'requisites_id','id');
    }    
    
    /**
     * Метод, accessor,
     * возвращает ссылку на скан
     * @return string
     */
    public function getImageAttribute() {
        if (Storage::disk('public')->exists($this->link_scan)) {
            return Storage::url($this->link_scan);
        } 
        return false;
    }
}

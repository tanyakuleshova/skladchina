<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequisitesProject extends Model
{
    use SoftDeletes;
    
    protected  $table = 'project_requisites';

    protected  $guarded = ['id'];

    public function galleries(){
        return $this->hasMany(GalleryProject::class,'requisites_id','id');
    }
    
}

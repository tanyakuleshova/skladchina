<?php

namespace App\Models\Sponsored;

use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Model;

class Sponsors extends Model
{
    protected $table='sponsored_project';

    protected $fillable=['sum'];

    public function project(){
        return $this->belongsTo(Project::class,'project_id','id');
    }
}

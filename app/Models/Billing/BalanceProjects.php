<?php

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Model;

use App\Models\Project\Project;


class BalanceProjects extends Model
{
    protected  $table='balance_projects';
    
    protected $fillable = ['balance_id','project_id'];
    

    /**
     * Обратная связь с таблицей проектов, получим одну запись или null
     */
    public function project(){
        return $this->belongsTo(Project::class,'project_id','id');
    }
    
    /**
     * Обратная связь с таблицей баланса, получим одну запись или null
     */
    public function balance(){
        return $this->belongsTo(Balance::class,'balance_id','id');
    }
}

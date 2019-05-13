<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project\Project;
use App\User;

class Comment extends Model
{
    use SoftDeletes;
    
    protected $table='comments';
    
    protected $guarded = [];
	
    public function project()
	{
            return $this->belongsTo(Project::class,'project_id','id');
	}
	
    public function user()
	{
            return $this->belongsTo(User::class,'user_id','id');
	}
	
    public function parentUser()
	{
            return $this->belongsTo(User::class,'parent_id','id');
	}
}
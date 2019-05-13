<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class VideoProject extends Model
{
        protected $table='project_video';

        protected $fillable = ['link_video'];

        public function projectVideo(){
            return $this->belongsTo(Project::class,'project_id','id');
        }
        
    /**
     * Метод, accessor,
     * возвращает ссылку на картинку подарка или дефолтную
     * @return string
     */
    public function getLinkAttribute() {
        if (Storage::disk('public')->exists($this->link_video)) {
            return Storage::url($this->link_video);
        }
        
        return $this->link_video;
    }
}

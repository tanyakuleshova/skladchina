<?php
namespace App\ObserversModels;

use App\Models\Project\Project;
use App\Models\Project\RequisitesProject;
use App\Models\Project\GalleryProject;

use App\Admin;

use Illuminate\Support\Facades\Storage;

/**
 * Наблюдатель за моделью подарков к проекту
 *
 * @author vlavlat
 */
class ProjectObserver {
    
    /**
     * Слушаем создание проекта
     * @param Project $project
     */
    public function created(Project $project) {
        $project->requisites()->create([]);
        
        $admins = Admin::where('id','!=',1)->get();
        if ($admins->isEmpty()) {
            $admin_id   = 1;
        } else {
            $admin      = $admins->random();
            $admin_id   = $admin->id;
        } 
        
        $project->update(['valid_steps'=>array(),'admin_id'=>$admin_id]);
    }
    
    /**
     * Слушаем удаление подарка.
     *
     * @param  Project $project
     * @return void
     */
    public function deleting(Project $project)
    {
        //если полное удаление удалить картинку
        if ($project->isForceDeleting()) {
            Storage::disk('public')->delete($project->poster_link);
            foreach ($project->requisites()->get() as $item) {
                $item->forceDelete();
            }
            foreach ($project->projectGifts()->get() as $item) {
                $item->forceDelete();
            }
            foreach ($project->projectUserGifts()->get() as $item) {
                $item->forceDelete();
            }
            
        } else {
            foreach ($project->requisites()->get() as $item) {
                $item->delete();
            }
            foreach ($project->projectGifts()->get() as $item) {
                $item->delete();
            }
            
            foreach ($project->projectUserGifts()->get() as $item) {
                $item->delete();
            }
            
        }  
    }
}

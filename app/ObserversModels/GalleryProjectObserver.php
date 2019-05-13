<?php
namespace App\ObserversModels;

use App\Models\Project\GalleryProject;
use Illuminate\Support\Facades\Storage;

/**
 * Наблюдатель за моделью подарков к проекту
 *
 * @author vlavlat
 */
class GalleryProjectObserver {
    
    
    /**
     * Слушаем удаление сканов документов к проекту.
     *
     * @param  GalleryProject $gift
     * @return void
     */
    public function deleting(GalleryProject $gift)
    {
        //если это полное удаление удалить картинку
        if ($gift->isForceDeleting()) {
            Storage::disk('public')->delete($gift->link_scan);
        }  
    }
}

<?php
namespace App\ObserversModels;

use App\Models\Project\RequisitesProject;
use Illuminate\Support\Facades\Storage;

/**
 * Наблюдатель за моделью подарков к проекту
 *
 * @author vlavlat
 */
class RequisitesProjectObserver {
    
    
    /**
     * Слушаем удаление сканов документов к проекту.
     *
     * @param  RequisitesProject $rp
     * @return void
     */
    public function deleting(RequisitesProject $rp)
    {
        //если это полное удаление
        if ($rp->isForceDeleting() && $rp->galleries()->count()) {
            foreach ($rp->galleries()->get() as $item) {
                $item->forceDelete();
            }
        } elseif ($rp->galleries()->count()) {
            foreach ($rp->galleries()->get() as $item) {
                $item->delete();
            }
        }  
    }
}

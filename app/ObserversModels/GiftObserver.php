<?php
namespace App\ObserversModels;

use App\Models\GiftProject\Gift;
use Illuminate\Support\Facades\Storage;

/**
 * Наблюдатель за моделью подарков к проекту
 *
 * @author vlavlat
 */
class GiftObserver {
    
    
    /**
     * Слушаем удаление подарка.
     *
     * @param  User  $user
     * @return void
     */
    public function deleting(Gift $gift)
    {
        //если это полное удаление удалить картинку
        if ($gift->isForceDeleting()) {
            Storage::disk('public')->delete($gift->image_link);
        }  
    }
}

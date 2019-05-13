<?php
namespace App\ObserversModels;

use App\Admin;

/**
 * Наблюдатель за моделью пользователя
 *
 * @author vlavlat
 */
class AdminObserver {
    
    
    /**
     * Прослушивание события создания пользователя.
     *
     * @param  Admin  $user
     * @return void
     */
    public function created(Admin $user)
    {
        $user->account()->create([]);
    }
}

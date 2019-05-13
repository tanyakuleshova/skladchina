<?php
namespace App\ObserversModels;

use App\User;

/**
 * Наблюдатель за моделью пользователя
 *
 * @author vlavlat
 */
class UserObserver {
    
    
    /**
     * Прослушивание события создания пользователя.
     *
     * @param  User  $user
     * @return void
     */
    public function created(User $user)
    {
        $user->account()->create([]);
    }
}

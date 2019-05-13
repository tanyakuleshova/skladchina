<?php

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Model;

use App\Models\Project\Project;


class BalanceTransactions extends Model
{
    protected  $table='balance_transactions';
    
    protected  $guarded = ['id'];
    
    /**
      * Атрибуты, которые должны быть преобразованы к базовым типам.
      *
      * @var array
      */
    protected $casts = [
      'history' => 'array',
    ];
    
    /**
     * Обратная связь с таблицей баланса, получим одну запись или null
     */
    public function balance(){
        return $this->belongsTo(Balance::class,'balance_id','id');
    }
}

<?php

use Illuminate\Database\Seeder;

class InitBalanceOperationType extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * php artisan db:seed --class=InitBalanceOperationType
     * 
     * @return void
     */
    public function run()
    {
        
        DB::table('balance_operations')->updateOrInsert(['id'=>1],[
            'id'        => 1,
            'code'      => 'none',
            'temp_name' => 'Неизвестное назначение'
        ]);
        
        
        DB::table('balance_operations')->updateOrInsert(['id'=>2],[
            'id'        => 2,
            'code'      => 'addAPI',
            'temp_name' => 'Пополнение баланса по API'
        ]);
        
        DB::table('balance_operations')->updateOrInsert(['id'=>3],[
            'id'        => 3,
            'code'      => 'donate',
            'temp_name' => 'Поддержка проекта без награды'
        ]);
        
        DB::table('balance_operations')->updateOrInsert(['id'=>4],[
            'id'        => 4,
            'code'      => 'forgift',
            'temp_name' => 'Поддержка проекта с наградой'
        ]);
        
        DB::table('balance_operations')->updateOrInsert(['id'=>5],[
            'id'        => 5,
            'code'      => 'reversupay',
            'temp_name' => 'Возрат реальных средств пользователю, по заявке'
        ]);
        
        DB::table('balance_operations')->updateOrInsert(['id'=>6],[
            'id'        => 6,
            'code'      => 'reversgift',
            'temp_name' => 'Возрат средств пользователю на баланс, по заявке'
        ]);
        
        DB::table('balance_operations')->updateOrInsert(['id'=>7],[
            'id'        => 7,
            'code'      => 'failproject',
            'temp_name' => 'Возрат средств, неуспешный проект'
        ]);
        
        /* ------------------------------------------------------------------*/
        
        DB::table('balance_status')->updateOrInsert(['id'=>1],[
            'id'        => 1,
            'code'      => 'pending',
            'temp_name' => 'Ожидаем'
        ]);
        
        DB::table('balance_status')->updateOrInsert(['id'=>2],[
            'id'        => 2,
            'code'      => 'rejected',
            'temp_name' => 'Отменён'
        ]);
        
        DB::table('balance_status')->updateOrInsert(['id'=>3],[
            'id'        => 3,
            'code'      => 'approved',
            'temp_name' => 'Подтверждён'
        ]);
    }
}

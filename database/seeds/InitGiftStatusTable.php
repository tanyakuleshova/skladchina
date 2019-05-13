<?php

use Illuminate\Database\Seeder;

class InitGiftStatusTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gift_status')->updateOrInsert(['id'=>1],[
            'id'        => 1,
            'code'      => 'zakaz',
            'temp_name' => 'Заказан'
        ]);
        
        DB::table('gift_status')->updateOrInsert(['id'=>2],[
            'id'        => 2,
            'code'      => 'rejected',
            'temp_name' => 'Отменён'
        ]);
        
        DB::table('gift_status')->updateOrInsert(['id'=>3],[
            'id'        => 3,
            'code'      => 'pending',
            'temp_name' => 'Отправлен'
        ]);
        
        DB::table('gift_status')->updateOrInsert(['id'=>4],[
            'id'        => 4,
            'code'      => 'approved',
            'temp_name' => 'Подтверждён'
        ]);
    }
}

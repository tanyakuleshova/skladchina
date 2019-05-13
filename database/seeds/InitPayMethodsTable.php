<?php

use Illuminate\Database\Seeder;

class InitPayMethodsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pay_methods')->updateOrInsert(['id'=>1],[
            'id'        => 1,
            'code'      => 'visa',
            'temp_name' => 'Карта Visa'
        ]);
        
        DB::table('pay_methods')->updateOrInsert(['id'=>2],[
            'id'        => 2,
            'code'      => 'mastercard',
            'temp_name' => 'Карта Mastercard'
        ]);
        
        DB::table('pay_methods')->updateOrInsert(['id'=>3],[
            'id'        => 3,
            'status'    => 0,
            'code'      => 'webmoney',
            'temp_name' => 'Кошелёк Webmoney1'
        ]);
        
        DB::table('pay_methods')->updateOrInsert(['id'=>4],[
            'id'        => 4,
            'status'    => 0,
            'code'      => 'other4',
            'temp_name' => 'Кошелёк Webmoney2'
        ]);
        
        DB::table('pay_methods')->updateOrInsert(['id'=>5],[
            'id'        => 5,
            'status'    => 0,
            'code'      => 'other5',
            'temp_name' => 'Кошелёк Webmoney3'
        ]);
        
        DB::table('pay_methods')->updateOrInsert(['id'=>6],[
            'id'        => 6,
            'status'    => 0,
            'code'      => 'other6',
            'temp_name' => 'Кошелёк Webmoney4'
        ]);
    }
}

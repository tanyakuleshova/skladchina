<?php

use Illuminate\Database\Seeder;

class InitGiftDeliveriesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gift_deliveries')->updateOrInsert(['id'=>10],[
            'id'                => 10,
            'code'              => 'no_delivery',
            'def_name'          => 'Без доставки',
            'def_description'   => 'Вознаграждение, не требует доставки.'
        ]);
        
        DB::table('gift_deliveries')->updateOrInsert(['id'=>20],[
            'id'                => 20,
            'code'              => 'author_delivery',
            'def_name'          => 'Доставка, за счёт автора',
            'def_description'   => 'Доставку вознаграждения оплачивает автор проекта.'
        ]);
        
        DB::table('gift_deliveries')->updateOrInsert(['id'=>30],[
            'id'                => 30,
            'code'              => 'user_delivery',
            'def_name'          => 'Доставка, за счёт получателя',
            'def_description'   => 'Доставку вознаграждения оплачивает получатель.'
        ]);
        
        
        
        DB::table('gift_deliveries_language')->updateOrInsert(['id'=>1],[
            'id'                => 1,
            'gift_deliveries_id'=> 10,
            'language'          => 'ru',
            'name'              => 'Без доставки',
            'description'       => 'Вознаграждение, не требует доставки.'
        ]);
        
        DB::table('gift_deliveries_language')->updateOrInsert(['id'=>2],[
            'id'                => 2,
            'gift_deliveries_id'=> 10,
            'language'          => 'uk',
            'name'              => 'Не потребує',
            'description'       => 'Винагорода, не вимагає доставки.'
        ]);
        
        DB::table('gift_deliveries_language')->updateOrInsert(['id'=>3],[
            'id'                => 3,
            'gift_deliveries_id'=> 10,
            'language'          => 'ua',
            'name'              => 'Не потребує',
            'description'       => 'Винагорода, не вимагає доставки.'
        ]);
        
        
        
        
        DB::table('gift_deliveries_language')->updateOrInsert(['id'=>4],[
            'id'                => 4,
            'gift_deliveries_id'=> 20,
            'language'          => 'ru',
            'name'              => 'Доставка, за счёт автора',
            'description'       => 'Доставку вознаграждения оплачивает автор проекта.'
        ]);
        
        DB::table('gift_deliveries_language')->updateOrInsert(['id'=>5],[
            'id'                => 5,
            'gift_deliveries_id'=> 20,
            'language'          => 'uk',
            'name'              => 'Доставка, за рахунок автора',
            'description'       => 'Доставку винагороди сплачує автор проекту.'
        ]);
        
        DB::table('gift_deliveries_language')->updateOrInsert(['id'=>6],[
            'id'                => 6,
            'gift_deliveries_id'=> 20,
            'language'          => 'ua',
            'name'              => 'Доставка, за рахунок автора',
            'description'       => 'Доставку винагороди сплачує автор проекту.'
        ]);
        
        
        
        
        DB::table('gift_deliveries_language')->updateOrInsert(['id'=>7],[
            'id'                => 7,
            'gift_deliveries_id'=> 30,
            'language'          => 'ru',
            'name'              => 'Доставка, за счёт получателя',
            'description'       => 'Доставку вознаграждения оплачивает получатель.'
        ]);
        
        DB::table('gift_deliveries_language')->updateOrInsert(['id'=>8],[
            'id'                => 8,
            'gift_deliveries_id'=> 30,
            'language'          => 'uk',
            'name'              => 'Доставка, за рахунок одержувача',
            'description'       => 'Доставку винагороди сплачує одержувач.'
        ]);
        
        DB::table('gift_deliveries_language')->updateOrInsert(['id'=>9],[
            'id'                => 9,
            'gift_deliveries_id'=> 30,
            'language'          => 'ua',
            'name'              => 'Доставка, за рахунок одержувача',
            'description'       => 'Доставку винагороди сплачує одержувач.'
        ]);
        
        
    }
}

<?php

use Illuminate\Database\Seeder;

class InitProjectStatusTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('project_status')->updateOrInsert(['id'=>10],[
            'id'            => 10,
            'name'          => 'pinding',
            'description'   => 'На модерации'
        ]);
        
        DB::table('project_status')->updateOrInsert(['id'=>20],[
            'id'            => 20,
            'name'          => 'rejected',
            'description'   => 'Не прошёл модерацию'
        ]);
        
        DB::table('project_status')->updateOrInsert(['id'=>30],[
            'id'            => 30,
            'name'          => 'approved',
            'description'   => 'Активный'
        ]);
        
        DB::table('project_status')->updateOrInsert(['id'=>40],[
            'id'            => 40,
            'name'          => 'closed_success',
            'description'   => 'Закрыт успешно'
        ]);
        
        DB::table('project_status')->updateOrInsert(['id'=>50],[
            'id'            => 50,
            'name'          => 'closed_fail',
            'description'   => 'Закрыт не успешно'
        ]);
        
        DB::table('project_status')->updateOrInsert(['id'=>60],[
            'id'            => 60,
            'name'          => 'closed_moderation',
            'description'   => 'Закрыт на рассмотрении'
        ]);
    }
}

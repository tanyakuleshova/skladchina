<?php

use Illuminate\Database\Seeder;

class InitProjectTypesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('project_types')->updateOrInsert(['id'=>1],[
            'id'        => 1,
            'code'      => 'all'
        ]);
        
        DB::table('project_types')->updateOrInsert(['id'=>2],[
            'id'        => 2,
            'code'      => 'timeout'
        ]);
        
        
        DB::table('project_types_description')->updateOrInsert(['id'=>1],[
            'id'                => 1,
            'project_types_id'  => 1,
            'language'          => 'ru',
            'name'              => 'Универсальный',
            'description'       => 'Тип универсальный: Проект может собрать больше необходимой суммы.'
        ]);
        
        DB::table('project_types_description')->updateOrInsert(['id'=>2],[
            'id'                => 2,
            'project_types_id'  => 1,
            'language'          => 'uk',
            'name'              => 'Універсальний',
            'description'       => 'Тип універсальний: Проект може зібрати більше зазначеної суми.'
        ]);
        
        DB::table('project_types_description')->updateOrInsert(['id'=>3],[
            'id'                => 3,
            'project_types_id'  => 1,
            'language'          => 'ua',
            'name'              => 'Універсальний',
            'description'       => 'Тип універсальний: Проект може зібрати більше зазначеної суми.'
        ]);
        
        
        
        DB::table('project_types_description')->updateOrInsert(['id'=>4],[
            'id'                => 4,
            'project_types_id'  => 2,
            'language'          => 'ru',
            'name'              => 'Безссрочный',
            'description'       => 'Тип безссрочный: Проект может собрать только указанную сумму.'
        ]);
        
        DB::table('project_types_description')->updateOrInsert(['id'=>5],[
            'id'                => 5,
            'project_types_id'  => 2,
            'language'          => 'uk',
            'name'              => 'Безстроковий',
            'description'       => 'Тип безстроковий: Проект може зібрати тільки вказану суму.'
        ]);
        
        DB::table('project_types_description')->updateOrInsert(['id'=>6],[
            'id'                => 6,
            'project_types_id'  => 2,
            'language'          => 'ua',
            'name'              => 'Безстроковий',
            'description'       => 'Тип безстроковий: Проект може зібрати тільки вказану суму.'
        ]);
        
        
    }
}

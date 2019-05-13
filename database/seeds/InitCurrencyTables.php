<?php

use Illuminate\Database\Seeder;

class InitCurrencyTables extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currency_language')->delete();
        DB::table('currency')->delete();
        
        DB::table('currency')->insert([
            'id'        => 1,
            'code'      => 'UAH',
            'iso'       => '980',
            'html'      => '&#8372;',
            'unicode'   => '0x20B4'
        ]);
        
        DB::table('currency_language')->insert([
            'id'            => 1,
            'currency_id'   => 1,
            'language'      => 'ru',
            'name'          => 'гривна',
            'short'         => 'грн.'
        ]);
        DB::table('currency_language')->insert([
            'id'            => 2,
            'currency_id'   => 1,
            'language'      => 'uk',
            'name'          => 'гривня',
            'short'         => 'грн.'
        ]);
        DB::table('currency_language')->insert([
            'id'            => 3,
            'currency_id'   => 1,
            'language'      => 'ua',
            'name'          => 'гривня',
            'short'         => 'грн.'
        ]);
    }
}

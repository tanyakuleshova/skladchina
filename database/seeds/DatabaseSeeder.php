<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(InitCurrencyTables::class);
         $this->call(InitBalanceOperationType::class);
         $this->call(InitGiftStatusTable::class);
         $this->call(InitPayMethodsTable::class);
         $this->call(InitProjectTypesTable::class);
         $this->call(InitProjectStatusTable::class);
         $this->call(InitGiftDeliveriesTable::class);
    }
}

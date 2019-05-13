<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Billing\Balance;
use App\Jobs\RejectedBalance;

class ClearPendingBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ClearPendingBalance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Pending Balance from time';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('START -> Clear Pending Balance from time');
        Log::info('START -> Clear Pending Balance from time');
        
        $balss = Balance::pending()->get();
        
        foreach ($balss as $balance) {
            if ($balance->updated_at < Carbon::now()->subHour(4)) {
                dispatch(new RejectedBalance($balance));
                $this->info('balance id = '.$balance->id);
            } else {
                $this->info('time wait balance id = '.$balance->id);
            }
        }
        
        $this->info('END -> Clear Pending Balance from time');
        Log::info('END -> Clear Pending Balance from time');
    }
}

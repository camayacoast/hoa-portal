<?php

namespace App\Console\Commands;

use App\Http\Repositories\GenerateBilling;
use Illuminate\Console\Command;

class GenerateBillingOneTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:onetime';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Billing per day';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(GenerateBilling $generateBilling)
    {
         $generateBilling->generate(3);
    }
}

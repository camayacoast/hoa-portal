<?php

namespace App\Console\Commands;

use App\Http\Repositories\GenerateBilling;
use Illuminate\Console\Command;

class GenerateBillingAnnually extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:annually';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(GenerateBilling $generateBilling)
    {
        return $generateBilling->generate(2);
    }
}

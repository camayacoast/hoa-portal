<?php

namespace App\Console\Commands;

use App\Models\Email;
use App\Notifications\SendingEmailNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;

class SendingEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sending:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatic Sending Email';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try{
            $email = Email::with(['user','schedule'])->where('hoa_email_sched','=',Carbon::now()->toDateString())->first();

            if($email){
                return $email->notify(new SendingEmailNotification());
            }
            return 0;
        }catch (\Exception $e){
            Log::alert($e);
        }

    }

    private function email_query($data){

    }
}

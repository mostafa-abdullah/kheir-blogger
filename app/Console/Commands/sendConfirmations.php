<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Feedback as Feedback;
class sendConfirmations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'confirmations:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Event Confirmations to User.';

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
        $z = new Feedback;
        $z->user_id=1;
        $z->subject = "1";
        $z->message = "1";
        $z->save();
    }
}

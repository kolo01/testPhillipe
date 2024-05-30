<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\Test;
use App\Models\User;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoie de email';

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
     * @return int
     */
    public function handle()
    {
        
        //Define a variable
        $email = "cherubin0225@gmail.com";
        $subject = "test";
        $message = "Email de test";
        
        $users = User::find(44);

        $val = [
            "email" => $users->email
        ];

        //Send a email to 
     $send = Mail::to($email)->queue(new Test($users));

      if ($send) {
           info("is ok");
      } else {
           info("not ok");
      }
        
        return Command::SUCCESS;
    }
}

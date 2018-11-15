<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
//use Illuminate\Foundation\Inspiring;

class CartEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:cart';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $mail = app('Illuminate\Mail\Mailer');

        $data = [];

        $mail->send('emails.password-reset', ['data' => $data], function ($mail) use ($data) {
            $mail->to('parkash.kumar@air-aroma.com')
                ->subject('Sample Email');
        });
           
        $this->info('User Name Change Successfully!');

        //return redirect()->to('/store/checkout');
    }
}

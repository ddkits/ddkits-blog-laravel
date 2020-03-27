<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FeedsOfTheHour extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feeds:hour';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command start a cron import feeds from all over to our site news';

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
        \App('\App\Http\Controllers\FeedsCont')->genAllfeeds();
        $this->info('test');
    }
}

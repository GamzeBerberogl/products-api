<?php

namespace App\Console\Commands;

use App\Models\Availability;
use Illuminate\Console\Command;
use GuzzleHttp\Client;


class All extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync All Assets';
    
    /**
     * Execute the console command.
     */
    public function handle()
    {

        $this->call('app:brands');
        $this->call('app:categories');
        $this->call('app:currency-types');
        $this->call('app:price-signs');
        $this->call('app:products');
        $this->call('app:product-types');

    }
}
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PriceSign;
use GuzzleHttp\Client;

class PriceSigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:price-signs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize unique price signs from the products API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();
        $url = env('PRODUCT_API_URL');
        $response = $client->get($url);
        $products = json_decode($response->getBody()->getContents(), true);

        $uniquePriceSigns = collect();

        foreach ($products as $product) {
            $priceSign = $product['price_sign'] ?? null; // Null coalescing operator to handle missing price signs

            // Process only valid price signs
            if ($priceSign && !$uniquePriceSigns->contains('name', $priceSign)) {
                $uniquePriceSigns->push(['name' => $priceSign]);
            }
        }

        $this->info('Unique price signs collected, starting to update the database.');

        foreach ($uniquePriceSigns as $priceSign) {
            $existingPriceSign = PriceSign::where('name', $priceSign['name'])->first();

            if (!$existingPriceSign) {
                $newPriceSign = new PriceSign(['name' => $priceSign['name']]);
                $newPriceSign->save();
                $this->info("Price sign added: {$newPriceSign->name}");
            }
        }

        $this->info('All price signs have been synchronized.');
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CurrencyType;
use GuzzleHttp\Client;

class CurrencyTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:currency-types';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize unique currency types from the products API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();
        $url = env('PRODUCT_API_URL');
        $response = $client->get($url);
        $products = json_decode($response->getBody()->getContents(), true);

        $uniqueCurrencyTypes = collect();

        foreach ($products as $product) {
            $currencyType = $product['currency'] ?? null; // Null coalescing operator to handle missing currency types

            // Process only valid currency types
            if ($currencyType && !$uniqueCurrencyTypes->contains('name', $currencyType)) {
                $uniqueCurrencyTypes->push(['name' => $currencyType]);
            }
        }

        $this->info('Unique currency types collected, starting to update the database.');

        foreach ($uniqueCurrencyTypes as $currencyType) {
            $existingCurrencyType = CurrencyType::where('name', $currencyType['name'])->first();

            if (!$existingCurrencyType) {
                $newCurrencyType = new CurrencyType(['name' => $currencyType['name']]);
                $newCurrencyType->save();
                $this->info("Currency type added: {$newCurrencyType->name}");
            }
        }

        $this->info('All currency types have been synchronized.');
    }
}

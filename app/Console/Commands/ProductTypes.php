<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ProductType;
use GuzzleHttp\Client;

class ProductTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:product-types';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize unique product types from the products API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();
        $url = env('PRODUCT_API_URL');
        $response = $client->get($url);
        $products = json_decode($response->getBody()->getContents(), true);

        $uniqueProductTypes = collect();

        foreach ($products as $product) {
            $productType = $product['product_type'] ?? null; // Null coalescing operator to handle missing product types

            // Process only valid product types
            if ($productType && !$uniqueProductTypes->contains('name', $productType)) {
                $uniqueProductTypes->push(['name' => $productType]);
            }
        }

        $this->info('Unique product types collected, starting to update the database.');

        foreach ($uniqueProductTypes as $productType) {
            $existingProductType = ProductType::where('name', $productType['name'])->first();

            if (!$existingProductType) {
                $newProductType = new ProductType(['name' => $productType['name']]);
                $newProductType->save();
                $this->info("Product type added: {$newProductType->name}");
            }
        }

        $this->info('All product types have been synchronized.');
    }
}

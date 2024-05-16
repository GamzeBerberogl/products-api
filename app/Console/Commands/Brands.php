<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Brand;
use GuzzleHttp\Client;

class Brands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:brands';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize unique brands from the products API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();
        $url = env('PRODUCT_API_URL');
        $response = $client->get($url);
        $products = json_decode($response->getBody()->getContents(), true);

        $uniqueBrands = collect();

        foreach ($products as $product) {
            $brandName = $product['brand'] ?? null; // Null coalescing operator kullanarak brand adının varlığını kontrol edin.

            // Sadece geçerli marka adlarını işle
            if ($brandName && !$uniqueBrands->contains('name', $brandName)) {
                $uniqueBrands->push(['name' => $brandName]);
            }
        }

        $this->info('Unique brands collected, starting to update the database.');

        foreach ($uniqueBrands as $brand) {
            $existingBrand = Brand::where('name', $brand['name'])->first();

            if (!$existingBrand) {
                $newBrand = new Brand(['name' => $brand['name']]);
                $newBrand->save();
                $this->info("Brand added: {$newBrand->name}");
            }
        }

        $this->info('All brands have been synchronized.');
    }
}
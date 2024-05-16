<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductType;
use App\Models\PriceSign;
use App\Models\CurrencyType;
use GuzzleHttp\Client;

class Products extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize products from the products API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();
        $url = env('PRODUCT_API_URL');
        $response = $client->get($url);
        $products = json_decode($response->getBody()->getContents(), true);

        foreach ($products as $productData) {
            $brand = Brand::firstOrCreate(['name' => $productData['brand'] ?? '']);
            $category = Category::firstOrCreate(['name' => $productData['category'] ?? '']);
            $productType = ProductType::firstOrCreate(['name' => $productData['product_type'] ?? '']);
            $priceSign = PriceSign::firstOrCreate(['name' => $productData['price_sign'] ?? '']);
            $currencyType = CurrencyType::firstOrCreate(['name' => $productData['currency'] ?? '']);

            // HTML etiketlerinden temizlenmiş ve kısaltılmış description
            $cleanDescription = strip_tags($productData['description'] ?? '');
            $shortDescription = substr($cleanDescription, 0, 1000);

            // Kısaltılmış name ve image_link
            $shortName = substr($productData['name'], 0, 255);
            $shortImageLink = substr($productData['image_link'], 0, 255);

            $product = Product::updateOrCreate(
                ['name' => $shortName],
                [
                    'brand_id' => $brand->id,
                    'category_id' => $category->id,
                    'product_type_id' => $productType->id,
                    'price_sign_id' => $priceSign->id,
                    'currency_type_id' => $currencyType->id,
                    'price' => $productData['price'] ?? 0,
                    'image_link' => $shortImageLink,
                    'description' => $shortDescription,
                    'is_active' => true, // Varsayılan olarak aktif olarak işaretliyoruz
                ]
            );

            $this->info("Product synchronized: {$shortName}");
        }

        $this->info('All products have been synchronized.');
    }
}

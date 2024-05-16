<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use GuzzleHttp\Client;

class Categories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize unique categories from the products API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();
        $url = env('PRODUCT_API_URL');
        $response = $client->get($url);
        $products = json_decode($response->getBody()->getContents(), true);

        $uniqueCategories = collect();

        foreach ($products as $product) {
            $categoryName = $product['category'] ?? null; // Null coalescing operator to handle missing category names

            // Process only valid category names
            if ($categoryName && !$uniqueCategories->contains('name', $categoryName)) {
                $uniqueCategories->push(['name' => $categoryName]);
            }
        }

        $this->info('Unique categories collected, starting to update the database.');

        foreach ($uniqueCategories as $category) {
            $existingCategory = Category::where('name', $category['name'])->first();

            if (!$existingCategory) {
                $newCategory = new Category(['name' => $category['name']]);
                $newCategory->save();
                $this->info("Category added: {$newCategory->name}");
            }
        }

        $this->info('All categories have been synchronized.');
    }
}

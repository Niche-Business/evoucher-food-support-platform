<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\FoodListing;
use App\Models\User;

// Get a local shop user
$shop = User::where('role', 'local_shop')->first();
if (!$shop) {
    echo "No local shop user found. Please create one first.\n";
    exit(1);
}

$foodItems = [
    // Free items
    ['item_name' => 'Fresh Apples', 'description' => 'Organic apples from local farm', 'listing_type' => 'free', 'quantity' => 50, 'unit' => 'kg'],
    ['item_name' => 'Bread Loaves', 'description' => 'Whole wheat bread', 'listing_type' => 'free', 'quantity' => 20, 'unit' => 'items'],
    ['item_name' => 'Carrots', 'description' => 'Fresh orange carrots', 'listing_type' => 'free', 'quantity' => 30, 'unit' => 'kg'],
    
    // Discounted items
    ['item_name' => 'Chicken Breasts', 'description' => '50% off - expires today', 'listing_type' => 'discounted', 'quantity' => 10, 'unit' => 'kg', 'discount_percentage' => 50],
    ['item_name' => 'Milk (1L)', 'description' => '30% discount', 'listing_type' => 'discounted', 'quantity' => 25, 'unit' => 'items', 'discount_percentage' => 30],
    ['item_name' => 'Yogurt Pots', 'description' => 'Multi-pack discount 40% off', 'listing_type' => 'discounted', 'quantity' => 15, 'unit' => 'packs', 'discount_percentage' => 40],
    ['item_name' => 'Cheddar Cheese', 'description' => 'Mature cheddar 35% off', 'listing_type' => 'discounted', 'quantity' => 8, 'unit' => 'kg', 'discount_percentage' => 35],
    
    // Surplus items
    ['item_name' => 'Bananas', 'description' => 'Surplus stock - must collect today', 'listing_type' => 'surplus', 'quantity' => 40, 'unit' => 'kg'],
    ['item_name' => 'Tomatoes', 'description' => 'Overstock - free to collect', 'listing_type' => 'surplus', 'quantity' => 25, 'unit' => 'kg'],
    ['item_name' => 'Lettuce Heads', 'description' => 'Surplus vegetables', 'listing_type' => 'surplus', 'quantity' => 30, 'unit' => 'items'],
];

foreach ($foodItems as $item) {
    FoodListing::create([
        'shop_user_id' => $shop->id,
        'item_name' => $item['item_name'],
        'description' => $item['description'],
        'listing_type' => $item['listing_type'],
        'quantity_available' => $item['quantity'],
        'unit' => $item['unit'],
        'discount_percentage' => $item['discount_percentage'] ?? null,
        'status' => 'available',
        'expiry_date' => now()->addDays(7)->toDateString(),
    ]);
    echo "Created: {$item['item_name']} ({$item['listing_type']})\n";
}

echo "\nFood listings seeded successfully!\n";

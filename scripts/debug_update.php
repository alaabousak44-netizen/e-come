<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\TravelPackage;

$package = TravelPackage::find(9);
if (! $package) {
    echo "package not found\n";
    exit(1);
}

$result = $package->update([
    'title' => 'Updated Test',
    'description' => 'Updated desc',
    'destination_city' => 'NewCity',
    'destination_country' => 'NC',
    'duration_days' => 4,
    'price_per_person' => 150.00,
    'max_capacity' => 12,
    'is_active' => 1,
]);

echo $result ? "ok\n" : "failed\n";

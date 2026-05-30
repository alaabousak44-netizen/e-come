<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\TravelPackage;

foreach (TravelPackage::all() as $package) {
    echo $package->package_id . ' | ' . $package->title . ' | ' . $package->destination_city . ' | ' . $package->destination_country . "\n";
}

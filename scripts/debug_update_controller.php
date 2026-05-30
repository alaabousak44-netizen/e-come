<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\AdminController;
use App\Models\TravelPackage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

$user = User::find(1);
if (! $user) {
    echo "No admin user with ID 1 found.\n";
    exit(1);
}

Auth::login($user);

$package = TravelPackage::first();
if (! $package) {
    echo "No travel package found.\n";
    exit(1);
}

$request = Request::create('/admin/packages/' . $package->package_id, 'POST', [
    'title' => 'Controller Update Test',
    'description' => 'Controller update description',
    'destination_city' => 'Controller City',
    'destination_country' => 'Controller Country',
    'duration_days' => 5,
    'price_per_person' => 99.99,
    'max_capacity' => 8,
    'is_active' => '1',
    '_method' => 'PUT',
]);

$controller = new AdminController();
$response = $controller->updatePackage($request, $package);

if (method_exists($response, 'getTargetUrl')) {
    echo "Redirect to: " . $response->getTargetUrl() . "\n";
} else {
    echo "Response type: " . get_class($response) . "\n";
}

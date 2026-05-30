<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\AdminController;
use App\Models\TravelPackage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

$user = User::find(1);
if (! $user) {
    echo "No admin user with ID 1 found.\n";
    exit(1);
}
Auth::login($user);

$package = TravelPackage::first();
if (! $package) {
    echo "No package found.\n";
    exit(1);
}

$tmpFile = tempnam(sys_get_temp_dir(), 'img');
file_put_contents($tmpFile, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8Xw8AAn8B9Q20VgAAAABJRU5ErkJggg=='));
$uploaded = new UploadedFile($tmpFile, 'test.png', 'image/png', null, true);

$request = Request::create('/admin/packages/' . $package->package_id, 'POST', [
    'title' => $package->title,
    'description' => $package->description,
    'destination_city' => $package->destination_city,
    'destination_country' => $package->destination_country,
    'duration_days' => $package->duration_days,
    'price_per_person' => $package->price_per_person,
    'max_capacity' => $package->max_capacity,
    'is_active' => '1',
    '_method' => 'PUT',
], [], ['images' => [$uploaded]], []);

$controller = new AdminController();
$response = $controller->updatePackage($request, $package);

echo 'Response: ' . get_class($response) . "\n";
if (method_exists($response, 'getTargetUrl')) {
    echo 'Redirect to: ' . $response->getTargetUrl() . "\n";
}

echo 'Package title after update: ' . TravelPackage::find($package->package_id)->title . "\n";

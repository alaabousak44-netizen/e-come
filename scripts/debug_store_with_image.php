<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\AdminController;
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

$tmpFile = tempnam(sys_get_temp_dir(), 'img');
file_put_contents($tmpFile, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8Xw8AAn8B9Q20VgAAAABJRU5ErkJggg=='));
$uploaded = new UploadedFile($tmpFile, 'test.png', 'image/png', null, true);

$request = Request::create('/admin/packages', 'POST', [
    'title' => 'Debug Image Create',
    'description' => 'Description for debug create',
    'destination_city' => 'Test City',
    'destination_country' => 'Test Country',
    'duration_days' => 2,
    'price_per_person' => 199.99,
    'max_capacity' => 4,
    'is_active' => '1',
], [], ['images' => [$uploaded]], []);

$controller = new AdminController();
$response = $controller->storePackage($request);
echo 'Response: ' . get_class($response) . "\n";
if (method_exists($response, 'getTargetUrl')) {
    echo 'Redirect to: ' . $response->getTargetUrl() . "\n";
}

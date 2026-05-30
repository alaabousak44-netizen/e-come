<?php

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use App\Models\TravelPackage;
use App\Models\User;
use App\Http\Controllers\AdminController;

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = User::first();
if ($user) {
    Auth::login($user);
}

$pkg = TravelPackage::first();
if (! $pkg) {
    echo "no package\n";
    exit(0);
}

$tmp = tempnam(sys_get_temp_dir(), 'img');
file_put_contents($tmp, hex2bin('89504e470d0a1a0a0000000d494844520000000100000001080200000090770d0b0000000b49444154789c6360000002000100d0ef2fbc0000000049454e44ae426082'));
$uploaded = new UploadedFile($tmp, 'test.png', 'image/png', UPLOAD_ERR_OK, true);
$data = [
    'title' => 'Test Updated',
    'description' => 'Updated desc',
    'destination_city' => 'City',
    'destination_country' => 'Country',
    'duration_days' => 5,
    'price_per_person' => 123.45,
    'max_capacity' => 12,
    'is_active' => '1',
];
$request = Request::create('/admin/packages/' . $pkg->package_id, 'POST', $data, [], ['images' => [$uploaded]], ['HTTP_X_HTTP_METHOD_OVERRIDE' => 'PUT']);

$controller = new AdminController();
$response = $controller->updatePackage($request, $pkg);
var_dump(get_class($response));
echo 'ok\n';
unlink($tmp);

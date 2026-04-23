<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Service;

// Find yoga service
$s = Service::where('title', 'like', '%Yoga%')->first();
if (!$s) {
    echo "No yoga service found\n";
    // Show any service with Activiti image
    $s = Service::where('image', 'like', '%Activiti%')->first();
    if (!$s) {
        echo "No Activiti service found\n";
        exit;
    }
}

echo "Service: {$s->title} (ID: {$s->id})\n";
echo "Image: {$s->image}\n";
echo "Public path of image: " . public_path($s->image) . "\n";
echo "File exists: " . (file_exists(public_path($s->image)) ? 'YES' : 'NO') . "\n";
echo "\nGallery:\n";
print_r($s->gallery);

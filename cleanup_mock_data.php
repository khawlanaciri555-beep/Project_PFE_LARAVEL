<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Transport;
use App\Models\Hotel;
use App\Models\Cooperative;

$realUserNames = ['kaoutar', 'Mahdi', 'ikrame', 'Hotel kech', 'vite', 'Admin VibKech'];
$realUserIds = User::whereIn('name', $realUserNames)->pluck('id')->toArray();

echo "Real User IDs: " . implode(', ', $realUserIds) . "\n";

$deletedTransports = Transport::whereNotIn('user_id', $realUserIds)->delete();
$deletedHotels = Hotel::whereNotIn('user_id', $realUserIds)->delete();
$deletedCoops = Cooperative::whereNotIn('user_id', $realUserIds)->delete();

echo "Deleted Transports: $deletedTransports\n";
echo "Deleted Hotels: $deletedHotels\n";
echo "Deleted Cooperatives: $deletedCoops\n";

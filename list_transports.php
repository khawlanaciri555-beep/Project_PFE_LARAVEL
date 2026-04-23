<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Transport;

$transports = Transport::with('user')->get();
foreach ($transports as $t) {
    echo "ID: {$t->id} | User: {$t->user->name} | Image: {$t->image}\n";
}

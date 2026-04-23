<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Transport;

$t = Transport::with('user', 'place')->whereHas('user', function($q){ $q->where('name', 'vite'); })->first();
if ($t) {
    echo "Transport ID: {$t->id} | User: {$t->user->name} | Place: " . ($t->place->name ?? 'None') . " | Image: {$t->image}\n";
} else {
    echo "No transport found for 'vite'\n";
}

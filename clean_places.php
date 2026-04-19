<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Keep places that have an image starting with /storage/places/ (which means they were synced from WhatsApp images)
$affected = DB::table('places')->where('image', 'NOT LIKE', '/storage/places/%')->delete();

echo "Deleted {$affected} places that had no real photos (WhatsApp images).\n";

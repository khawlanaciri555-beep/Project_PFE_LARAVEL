<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Transport;
use App\Http\Resources\TransportResource;
use Illuminate\Http\Request;

$transport = Transport::find(11);
if (!$transport) {
    echo "Transport 11 NOT FOUND in DB\n";
    exit;
}

$resource = new TransportResource($transport->load(['services', 'user']));
$request = Request::create('/api/transports/11', 'GET');
$data = $resource->toArray($request);

echo "API Response for Transport 11:\n";
print_r($data);

<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Vehicle;

$count = Vehicle::count();
echo "Total Vehicles: $count\n";

$latest = Vehicle::latest()->get();
foreach($latest as $v) {
    echo "ID: $v->id | Name: $v->name | Type: $v->type | Domicile: $v->domicile | Status: $v->status\n";
}

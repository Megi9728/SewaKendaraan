<?php
require 'vendor/autoload.php';

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

$manager = new ImageManager(new Driver());
$image = $manager->decodePath('public/logo.png'); // read existing image

$watermarkPath = 'public/logo.png';
if (file_exists($watermarkPath)) {
    $watermark = $manager->decodePath($watermarkPath);
    $watermarkWidth = intval($image->width() * 0.3);
    $watermark->scale(width: $watermarkWidth);
    
    $image->insert($watermark, 20, 20, 'bottom-right');
}

$encoded = $image->encode(); // should know it's a PNG
file_put_contents('public/test_out.png', (string) $encoded);
echo "Success\n";

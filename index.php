<?php
require __DIR__ . '/vendor/autoload.php';

use Bukwid\PHExifTool\ExifTool;

$exifTool = new ExifTool();

$file = __DIR__ . '/img.jpg';
//echo 'ExifTool version: ' . $exifTool->version();

try {
    $metadata = $exifTool->read($file);
    print_r($metadata);
} catch (RuntimeException $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}
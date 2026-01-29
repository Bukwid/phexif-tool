<?php
require __DIR__ . '/vendor/autoload.php';

use Bukwid\PHExifTool\ExifTool;

$exifTool = new ExifTool();
echo 'ExifTool version: ' . $exifTool->version();
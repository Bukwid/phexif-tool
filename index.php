<?php
require __DIR__ . '/vendor/autoload.php';

use Bukwid\PHExifTool\ExifTool;

$exifTool = new ExifTool();

$file = __DIR__ . '/user_credential.pdf';

// for checking version
//echo 'ExifTool version: ' . $exifTool->version();

// for reading metadata
try {
    $metadata = $exifTool->read($file);
    print_r($metadata);
} catch (RuntimeException $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}

// for writing metadata
// try {
//     $exifTool->write($file, [
//         'Title' => 'PDF Auth sample file',
//     ]);
// } catch (RuntimeException $e) {
//     echo 'Error: ' . $e->getMessage() . PHP_EOL;
// }
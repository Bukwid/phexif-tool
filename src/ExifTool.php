<?php

namespace Bukwid\PHExifTool;

use Bukwid\PHExifTool\Exception\BinaryNotFoundException;
use RuntimeException;

final class ExifTool
{
    private string $binary;

    public function __construct(?string $binary = null)
    {
        if(!function_exists('exec')) {
            throw new RuntimeException('The exec() function is disabled. Please enable it to use PHExifTool.');
        }

        $this->binary = BinaryLocator::locate($binary);
    }

    public function version(): string
    {
        $cmd = escapeshellcmd($this->binary) . ' -ver';
        exec($cmd, $output, $code);

        if($code !== 0 || empty($output)) {
            throw new RuntimeException('Failed to execute exiftool command.');
        }

        return trim($output[0] ?? '');
    }
}
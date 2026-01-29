<?php

namespace Bukwid\PHExifTool;
use RuntimeException;

final class ExifTool
{
    private string $binary;

    public function __construct(string $binary = 'exiftool')
    {
        if(!function_exists('exec')) {
            throw new RuntimeException('The exec function is disabled. Please enable it to use PHExifTool.');
        }

        $this->binary = $binary;
    }

    public function version(): string
    {
        $cmd = escapeshellcmd($this->binary) . ' -ver';
        exec($cmd, $output, $code);

        if($code !== 0 || empty($output)) {
            throw new RuntimeException('Failed to execute exiftool command. Exiftool may not be installed or is not accessible.');
        }

        return trim($output[0] ?? '');
    }
}
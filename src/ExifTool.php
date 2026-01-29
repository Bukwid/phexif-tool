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

    /**
     * Read metadata from a file.
     * 
     * @param string $file Path to the file.
     * @return array Associative array of metadata.
     */
    public function read(string $file): array
    {
        if(!file_exists($file) || !is_readable($file)) {
            throw new RuntimeException("File not found or not readable: $file");
        }

        $cmd = escapeshellarg($this->binary) . ' -j ' . escapeshellarg($file);
        exec($cmd, $output, $code);

        if($code !== 0 || empty($output)) {
            throw new RuntimeException('Failed to read metadata from file.');
        }

        $json = implode("\n", $output);
        $data = json_decode($json, true);

        if(json_last_error() !== JSON_ERROR_NONE || !is_array($data) || empty($data)) {
            throw new RuntimeException("Failed to parse JSON metadata from $file");
        }

        return $data[0];
    }
}
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

    /**
     * Write metadata to a file.
     * 
     * @param string $file Path to the file.
     * @param array $metadata Associative array of metadata to write.
     * @param bool $overwrite Whether to overwrite the original file (default true).
    */
    public function write(string $file, array $tags, bool $overwrite = true): void
    {
        if(!file_exists($file) || !is_writable($file)) {
            throw new RuntimeException("File not found or not writable: $file");
        }

        if(empty($tags)) {
            throw new RuntimeException("No metadata tags provided to write.");
        }

        $args = [];

        foreach($tags as $tag => $value) {
            $args[] = sprintf('-%s=%s', $tag, escapeshellarg($value));
        }

        $overwriteFlag = $overwrite ? '-overwrite_original' : '';

        $cmd = escapeshellarg($this->binary) . ' ' . $overwriteFlag . ' ' . implode(' ', $args) . ' ' . escapeshellarg($file);

        exec($cmd, $output, $code);

        if($code !== 0) {
            throw new RuntimeException('Failed to write metadata to file.');
        }
    }
}
<?php

namespace Bukwid\PHExifTool;

use Bukwid\PHExifTool\Exception\BinaryNotFoundException;

final class BinaryLocator
{
    public static function locate(?string $customPath = null): string
    {
        if($customPath && is_executable($customPath)) {
            return $customPath;
        }

        $osFamily = PHP_OS_FAMILY;

        $command = $osFamily === 'Windows' ? 'where exiftool' : 'which exiftool';
        $path = trim(shell_exec($command  . ' 2>NUL'));

        if($path && is_executable($path)) {
            return $path;
        }

        $binary = match($osFamily) {
            'Windows' => __DIR__ . '/../bin/windows/exiftool.exe',
            'Darwin' => __DIR__ . '/../bin/macos/exiftool',
            'Linux' => __DIR__ . '/../bin/linux/exiftool',
            default => null,
        };

        if($binary && is_executable($binary)) {
            return $binary;
        }

        throw new BinaryNotFoundException(
            'ExifTool binary not found. Please ensure ExifTool is installed and accessible.'
        );
    }
}
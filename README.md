# PHExifTool

[![Version](https://img.shields.io/badge/version-0.1.0-blue.svg)](https://github.com/Bukwid/PHExifTool)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

**PHExifTool** is a lightweight PHP bridge for [Phil Harvey's ExifTool](https://exiftool.org/). It provides a clean, object-oriented interface to read and write metadata across hundreds of file formats (JPEG, PNG, PDF, TIFF, and more).

---

## ⚠️ Important Note

This library acts as a **bridge**. It does not rewrite the ExifTool logic in PHP; instead, it executes the `exiftool` binary on your system and parses the results.

### Dependencies
* **Non-Windows Users (Linux/macOS):** You must have `exiftool` installed on your system.
    * *Ubuntu/Debian:* `sudo apt install exiftool`
    * *macOS:* `brew install exiftool`
* **Windows Users:** Basic support is available, but the `exiftool.exe` must be in your system PATH.
* **Future Updates:** We plan to include bundled binaries in future versions to remove the manual installation requirement.

---

## 🚀 Installation

You can install the package via Composer:

```bash
composer require bukwid/phexiftool
```

## 💡 Basic Usage
Remeber to define the composer autoload.

### Initialization
```php
use Bukwid\PHExifTool\ExifTool;

$exifTool = new ExifTool();
```

### Read Function
```php
$file = __DIR__ . '/your_file.png';
try {
    $metadata = $exifTool->read($file);
    print_r($metadata);
} catch (RuntimeException $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}
```

### Write Function
```php
$file = __DIR__ . '/your_file.png';
try {
    $exifTool->write($file, [
        'Title' => 'PDF Auth sample file',
    ]);
} catch (RuntimeException $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}
```

## 🛠 Features
- Metadata Extraction: Access EXIF, GPS, IPTC, XMP, and more.
- Metadata Writing: Easily update tags using simple key-value arrays.
- Format Support: Works with any file format supported by the underlying ExifTool binary.

## 🗺 Roadmap
[ ] Add support for batch file processing.
[ ] Implement JSON output parsing for more complex data structures.
[ ] Add helper methods for common tags (e.g., $exifTool->getGPS()).

## 📄 License
MIT License

Copyright (c) 2025 Kenneth Buquid

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

## 🙌 Credits
Built with ❤️ by Kenneth Leonard M. Buquid. Inspired to create this in order to complete PDF-AUTH.

<?php

namespace BackbonePhp;

use BackbonePhp\Exception\FileNotFoundException;
use BackbonePhp\Exception\InvalidJsonException;

class File {

    /**
     * Loads data as array from a JSON file
     * 
     * @param string $path Path to JSON file
     * @param bool $assoc Whether to convert JSON into associative arrays.
     * @return array Decoded JSON data
     * @throws FileNotFoundException If file at $path does not exist
     * @throws InvalidJsonException If file at $path can't be decoded
     */
    public static function loadJson($path, $assoc = false) {
        if (!file_exists($path)) {
            throw new FileNotFoundException('File not found: "' . $path . '"');
        }
        $json = file_get_contents($path);
        $data = json_decode($json, $assoc);
        $error = json_last_error();
        if ($error) {
            throw new InvalidJsonException('File not found');
        }
        return $data;
    }
    
}

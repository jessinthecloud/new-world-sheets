<?php

namespace App\Converters;

use App\Converters\Concerns\Converter;

class JsonConverter implements Converter
{
    public function convert($data)
    {
        return json_decode(
            $this->removeInvalidHex(file_get_contents($data)),
            true
       );
    }

    /**
     * Remove invalid hex characters from a string
     *
     * @param  string $string string to sanitize
     *
     * @return string         sanitized string
     */
    public function removeInvalidHex(string $string) : string
    {
        return preg_replace('/[\x00-\x1F\x7F]/u', '', $string);
    }
}
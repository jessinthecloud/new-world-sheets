<?php

namespace App\Converters;

use App\Converters\Concerns\Converter;
use Illuminate\Filesystem\Filesystem;

class JsonConverter extends DataConverter
{
    public function convert( $data=null )
    {
        return json_decode(
            $this->removeInvalidHex($data),
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
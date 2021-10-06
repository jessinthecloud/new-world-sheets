<?php

namespace App\Http;

interface Fetcher
{
    public function fetch(string $url_piece, ?int $page=null, ?int $sleep=null);
}
<?php

namespace App\Http;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DataFetcher implements Fetcher
{
    protected string $base_url;
    
    public function __construct(string $base_url)
    {
        $this->base_url = $base_url;
    }
    
    protected function buildUrl(string $url_piece, ?int $page=null) : string
    {
        return $this->base_url.$url_piece . (isset($page) ? '?page='.$page : '');
    }

    protected function buildFilename(string $url_piece, ?int $page=null) : string
    {
        $path_piece = Str::lower(Str::replace('/', '-', $url_piece));
        // if there was no /, don't split by hyphen
        $path_piece = (substr_count($url_piece, '/') > 0) ? Str::beforeLast($path_piece, '-') : $path_piece;
        
        // if there was no /, don't split by hyphen
        $filename = (substr_count($url_piece, '/') > 0) ? Str::afterLast($path_piece, '-') : $path_piece;
        $filename .= isset($page) ? '-'.$page : '';
        
        $path = 'json/'.$path_piece.'/';
    
    dump($url_piece, $path, $filename);
    
        return $path.$filename;
    }

    protected function makeRequest(string $url, string $filepath, string $content_type='application/json')
    {
        $response = Http::accept( $content_type )->get( $url );

        $filepath .= '.'.Str::afterLast($content_type, '/');

dump( $url, $filepath, $response, $response->body() );

        if ( $response->successful() ) {
            Storage::disk( 'local' )->put(
                $filepath,
                $response->body()
            );
        } else {
            ddd( 'Request failed: ', $response->status(), $response->headers(), $response->body() );
        }
    }

    public function fetch(string $url_piece, ?int $page=null, ?int $sleep=null)
    {
        $this->makeRequest(
            $this->buildUrl($url_piece, $page),
            $this->buildFilename($url_piece, $page)
        );
        
        if(isset($sleep)){
            // don't spam requests
            sleep($sleep);
        }
    }
}
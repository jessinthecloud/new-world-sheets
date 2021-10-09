<?php

namespace App\Converters;

use App\Http\Client\Fetcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

abstract class DataConverter implements Concerns\Converter
{
    protected Fetcher $fetcher;

    public function __construct(Fetcher $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    /**
     * get all files from a given directory
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     * @param                                   $directory
     * @param string                            $namespace
     *
     * @return array
     * @throws \Exception
     */
    public function fromPath(Filesystem $filesystem, $directory, string $namespace, string $type_key ) : array
    {
        $files = $filesystem->files($directory);
        $data = [];

        foreach($files as $file){
            $data []= $this->fromFile($file, $namespace, $type_key);
        }
        
        return $data;
    }

    /**
     * get contents from file obj or path and convert
     * 
     * @param        $file
     * @param string $namespace
     *
     * @throws \Exception
     */
    public function fromFile( $file, string $namespace, string $type_key )
    {
        // TODO: error/check for SplFileInfo instance
        
        // get from SplFileInfo or filename
        $contents = (is_a($file, 'SplFileInfo')) ? $file->getContents() : file_get_contents($file);
        
        $data = $this->convert($contents);

        $this->load($data['subjects']['data'], $namespace, $type_key);
    }

    /**
     * loop data for saving 
     * 
     * @param        $data
     * @param string $namespace
     */
    public function load( $data, string $namespace, string $type_key )
    {
//dump('load\'s data');
//dump($data);
        // save to db
        foreach($data as $item){
//dump('item', $item);
            if( !isset($item['attributes'])){
                continue;
            }

            $class = $namespace.Str::studly(
                $item['attributes'][$type_key] ?? $item[$type_key]
            );

            $this->save($item['attributes'], $class);
        }
    }

    /**
     * get more details and save all to db 
     * 
     * @param array  $data
     * @param string $class
     */
    protected function save(array $data, string $class)
    {
        // TODO: go get details
        // $this->fetchDetails($data);

        // TODO: add details to $data

        // save to db
        $class::updateOrCreate(
            // unique cols
            ['id'=>$data['id'], 'slug'=>$data['slug']],
            // data to save
            $data
        );
    }

    /**
     * get any more details via http request
     * 
     * @param array  $data
     * @param string $type
     */
    protected function fetchDetails(array $data, string $type)
    {
        if(isset($data['slug'])){
            $fetched_data_array []= $this->fetcher->fetch(
                $type.'/'.$data['slug'],
                null,
                1,
                'text/html'
            );
        } //*/

        if(isset($data['cdn_asset_path']) && isset($data['slug'])){
            $this->fetcher->makeRequest(
                $data['cdn_asset_path'],
                Str::afterLast($data['cdn_asset_path'], '/'),
                'text/html',
            );
            sleep(1);
        }
    }
}
<?php

namespace App\Converters;

use App\Converters\Concerns\Converter;
use App\Http\Client\Fetcher;
use App\Models\Items\Armor;
use DirectoryIterator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ItemConverter
{

    public Converter $converter;
    protected Fetcher $fetcher;

    public function __construct(Converter $converter, Fetcher $fetcher)
    {
        $this->converter = $converter;
        $this->fetcher = $fetcher;
    }

    public function loadData($dir, $class)
    {
        // load files to read data from
        $filesystem = new Filesystem();

        $files = $filesystem->files($dir); // Storage::files($dir); // doesnt work?????
        $data = [];
/*foreach (new DirectoryIterator('/var/www/html/storage/app/json') as $file) {
    if($file->isDot()) continue;
    print $file->getFilename() . '<br>';
}        
ddd((new Filesystem())->files($dir), Storage::files($dir), $dir, $files);*/
//dump($files);
        foreach($files as $file){
//dump($file, $file->getRealPath());        
            $data []= $file->getRealPath();
        }
        
        $data = $this->fromJson($data, $class);
        
        return $data;
    }

    public function fromJson($data, $class)
    {
        $decoded_data_array = [];
        $fetched_data_array = [];
  
        if(is_array($data)){
//dump('is array');
            foreach($data as $entry){
//dump('filename: '.$entry);
//print_r('<xmp>'.$entry.'</xmp>');
//die;
                $decoded_data = $this->converter->convert($entry)['subjects']['data'];
//dump($decoded_data);
                $decoded_data_array []= $decoded_data;

                foreach($decoded_data as $item){
                
                    // save to db
//                    $class::updateOrCreate($item['attributes']);

                    // go get details
/*                    if(isset($item['attributes']['slug'])){
//dump($item['attributes']['slug']);
                        $fetched_data_array []= $this->fetcher->fetch(
                            'item/'.$item['attributes']['slug'], 
                            null, 
                            1, 
                            'text/html'
                        );
//ddd($fetched_data_array);
                    }*/

//dump($item['attributes']['cdn_asset_path']);
                    if(isset($item['attributes']['cdn_asset_path']) && isset($item['attributes']['slug'])){
                        $this->fetcher->makeRequest(
                            $item['attributes']['cdn_asset_path'],
                            Str::afterLast($item['attributes']['cdn_asset_path'], '/'),
                            'text/html',
                        );
                        sleep(1);
//ddd('----');
                    }
                }
            } // end foreach
        }
//dump('=====================');

    }
}   
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Http\Client\Fetcher;

class NwfController
{
    private int $start_page;
    private Fetcher $fetcher;
    
    public function __construct(Request $request, Fetcher $fetcher)
    {
        $this->fetcher = $fetcher;
        $this->start_page = $request->page ?? 1;
    }

    public function all(string $category, ?string $type=null)
    {
        $this->fetcher->getAll($this->start_page);
    }

    public function category(string $category)
    {
        $this->fetcher->getCategory($category, $this->start_page);
    }

    public function categoryType(string $category, string $type)
    {
        $this->fetcher->getCategoryType($category, $type, $this->start_page);
    }

    public function item(string $slug)
    {
        $this->fetcher->getItemDetails($slug);
    }

    public function recipe(string $slug)
    {
        $this->fetcher->getRecipeDetails($slug);
    }
    
}
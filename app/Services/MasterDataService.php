<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;



class MasterDataService
{
    public function getCategories()
    {
        $response = Http::inventory()->get('/categories');
    }

}

<?php
namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CategoryService
{
    public function getCategories()
    {
        $response = Http::inventory()->get('/categories');

        return $response->json();
    }



}

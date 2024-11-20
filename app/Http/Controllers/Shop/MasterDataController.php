<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;

class MasterDataController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function __invoke()
    {
        // get categories
        $categories = $this->categoryService->getCategories();


        dd($categories);



    }

}

<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductService
{
    public static function  getPopularProducts():JsonResponse
    {
        try {
            $products = Product::get();
            return success("show all popular products", $products);
        } catch (\Exception $e) {
           return failure("show all popular products failed",500);
        }
    }

}

<?php

namespace App\Services;

use App\Models\Category;
use Exception;

class CategoryService
{
    public static function getCategories(): mixed
    {
        try {
            $categories = Category::with('subcategories.subchilds')->get()->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'image' => $category->image,
                    'subcategories' => $category->subcategories->map(function ($subcategory) {
                        return [
                            'id' => $subcategory->id,
                            'name' => $subcategory->name,
                            'slug' => $subcategory->slug,
                            'image' => $subcategory->image,
                            'subchilds' => $subcategory->subchilds->map(function ($subchild) {
                                return [
                                    'id'    => $subchild->id,
                                    'name'  => $subchild->name,
                                    'slug'  => $subchild->slug,
                                    'image' => $subchild->image,
                                ];
                            }),
                        ];
                    }),
                ];
            });
            return  success("show all category",$categories);
        } catch (Exception $e) {
            return  failure($e->getMessage(),500);
        }
    }
}

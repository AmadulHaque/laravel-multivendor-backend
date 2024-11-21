<?php
namespace App\Services;
use App\Models\AttributeOption;
use App\Models\Unit;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\ProductType;
use App\Traits\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


class MasterDataService
{
    public function getMasterResource():mixed
    {
        $response = Http::inventory()->get('/master-resource');
        return $response->json();
    }

    public function storeCategory(array $categories):bool
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Transaction::retryAndRollback(function () use ($categories) {
            foreach ($categories as $categoryData) {
                // Insert the main category
                $category = Category::create([
                    'name' => $categoryData['name'],
                    'slug' => $categoryData['slug'], 
                    'parent_id' => null,
                ]);
    
                // Insert subcategories
                foreach ($categoryData['subcategories'] as $subcategoryData) {
                    $subcategory = Category::create([
                        'name' => $subcategoryData['name'],
                        'slug' => $subcategoryData['slug'],
                        'parent_id' => $category->id,
                    ]);
    
                    // Insert subchilds
                    foreach ($subcategoryData['subchilds'] as $subchildData) {
                        Category::create([
                            'name' => $subchildData['name'],
                            'slug' => $subchildData['slug'], 
                            'parent_id' => $subcategory->id,
                        ]);
                    }
                }
            }
        });
        return true;
    }
    
    public function storeBrand(array $brands):bool
    {
        foreach ($brands as $brandData)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('brands')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            Transaction::retryAndRollback(function () use ($brandData) {
                Brand::create([
                    'name'  => $brandData['name'],
                    'slug'  => $brandData['slug'],
                    'status'=> $brandData['status'],
                ]);
            });
        }
        return true;
    }

    public function storeUnit(array $units):bool
    {
        foreach ($units as $unitData)
        {
            DB::statement(query: 'SET FOREIGN_KEY_CHECKS=0;');
            DB::table(table: 'units')->truncate();
            DB::statement(query: 'SET FOREIGN_KEY_CHECKS=1;');

            Transaction::retryAndRollback(callback: function () use ($unitData) {
                Unit::create(attributes: [
                    'name'  => $unitData['name'],
                    'slug'  => $unitData['slug'],
                    'status'=> $unitData['status'],
                ]);
            });
        }
        return true;
    }

    // 
    public function storeProductType(array $product_types):bool
    {
        foreach ($product_types as $typeData)
        {
            DB::statement(query: 'SET FOREIGN_KEY_CHECKS=0;');
            DB::table(table: 'product_types')->truncate();
            DB::statement(query: 'SET FOREIGN_KEY_CHECKS=1;');

            Transaction::retryAndRollback(callback: function () use ($typeData) {
                ProductType::create(attributes: [
                    'name'  => $typeData['name'],
                    'status'=> $typeData['status'],
                ]);
            });
        }
        return true;
    }
    public function storeAttribute(array $attributes):bool
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('attributes')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach ($attributes as $data)
        {
            Transaction::retryAndRollback(callback: function () use ($data) {
                Attribute::create(attributes: [
                    'name'  => $data['name'],
                ]);
            });
        }
        return true;
    }


    public function storeAttributeOption(array $attributes_options):bool
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('attribute_options')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        foreach ($attributes_options as $data)
        {
            Transaction::retryAndRollback(function () use ($data) {
                AttributeOption::create([
                    'attribute_id'  => $data['attribute_id'],
                    'value'         => $data['attribute_value'],
                ]);
            });
        }
        return true;
    }


}

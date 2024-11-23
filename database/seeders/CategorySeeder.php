<?php

namespace Database\Seeders;

use App\Media\Media;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubCategoryChild;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('categories')->truncate();
        DB::table('sub_categories')->truncate();
        DB::table('sub_category_children')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::beginTransaction();

        try {
            $categories = [
                'Electronics' => [
                    'slug' => 'electronics',
                    'image' => public_path('images/category/xiaomi.png'),
                    'subcategories' => [
                        'Mobiles' => [
                            'slug' => 'mobiles',
                            'image' => public_path('images/category/samsung.jpeg'),
                            'children' => [
                                ['name' => 'Smartphones', 'slug' => 'smartphones', 'image' => public_path('images/category/xiaomi.png')],
                                ['name' => 'Feature Phones', 'slug' => 'feature-phones', 'image' => public_path('images/category/xiaomi.png')],
                            ]
                        ],
                        'TVs' => [
                            'slug' => 'tvs',
                            'image' => public_path('images/category/samsung.jpeg'),
                            'children' => [
                                ['name' => 'Smart TV', 'slug' => 'smart-tv', 'image' => public_path('images/category/xiaomi.png')],
                                ['name' => 'OLED TV', 'slug' => 'oled-tv', 'image' => public_path('images/category/xiaomi.png')],
                            ]
                        ]
                    ]
                ],
                'Fashion' => [
                    'slug' => 'fashion',
                    'image' => public_path('images/category/xiaomi.png'),
                    'subcategories' => [
                        'Clothing' => [
                            'slug' => 'clothing',
                            'image' => public_path('images/category/xiaomi.png'),
                            'children' => [
                                ['name' => 'Men\'s Clothing', 'slug' => 'mens-clothing', 'image' => public_path('images/category/xiaomi.png')],
                                ['name' => 'Women\'s Clothing', 'slug' => 'womens-clothing', 'image' => public_path('images/category/xiaomi.png')],
                            ]
                        ],
                        'Accessories' => [
                            'slug' => 'accessories',
                            'image' => public_path('images/category/samsung.jpeg'),
                            'children' => [
                                ['name' => 'Watches', 'slug' => 'watches', 'image' => public_path('images/category/xiaomi.png')],
                                ['name' => 'Bags', 'slug' => 'bags', 'image' => public_path('images/category/samsung.jpeg')],
                            ]
                        ]
                    ]
                ],
            ];

            foreach ($categories as $categoryName => $categoryData) {
                // Create Category and Attach Image
                $category = Category::updateOrCreate(
                    ['name' => $categoryName, 'slug' => $categoryData['slug']],
                    [
                        'status' => 1,
                        'added_by' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]
                );
                // Attach category image from disk
                if (file_exists($categoryData['image'])) {
                    // $category->addMedia($categoryData['image'], 'images', ['tags' => '']);
                    $category->media()->create([
                        'collection_name' => 'images',
                        'file_path' => $categoryData['image'],
                        'file_type' => 'image/jpeg',
                    ]);
                } else {
                    Log::info("Image not found for category: $categoryName");
                }

                foreach ($categoryData['subcategories'] as $subCategoryName => $subCategoryData) {
                    // Create Subcategory and Attach Image
                    $subCategory = SubCategory::updateOrCreate(
                        ['name' => $subCategoryName, 'slug' => $subCategoryData['slug'], 'category_id' => $category->id],
                        [
                            'status' => 1,
                            'added_by' => 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]
                    );

                    // Attach subcategory image from disk
                    if (file_exists($subCategoryData['image'])) {
                        // $subCategory->addMedia($subCategoryData['image'], 'images', ['tags' => '']);
                        $subCategory->media()->create([
                            'collection_name' => 'images',
                            'file_path' => $subCategoryData['image'],
                            'file_type' => 'image/jpeg',
                        ]);
                    } else {
                        Log::info("Image not found for subcategory: $subCategoryName");
                    }

                    foreach ($subCategoryData['children'] as $childData) {
                        // Create Subcategory Child and Attach Image
                        $subCategoryChild = SubCategoryChild::updateOrCreate(
                            ['name' => $childData['name'], 'slug' => $childData['slug'], 'sub_category_id' => $subCategory->id],
                            [
                                'status' => 1,
                                'added_by' => 1,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]
                        );

                        // Attach subcategory child image from disk
                        if (file_exists($childData['image'])) {
                            // $subCategoryChild->addMedia($childData['image'], 'images', ['tags' => '']);
                            $subCategoryChild->media()->create([
                                'collection_name' => 'images',
                                'file_path' => $categoryData['image'],
                                'file_type' => 'image/jpeg',
                            ]);
                        } else {
                            Log::info("Image not found for subcategory child: {$childData['name']}");
                        }
                    }
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Seeder failed: ' . $e->getMessage());
        }
    }
}

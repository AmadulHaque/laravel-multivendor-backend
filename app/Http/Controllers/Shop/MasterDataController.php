<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\MasterDataService;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    protected $masterDataService;
    public function __construct(MasterDataService $masterDataService)
    {
        $this->masterDataService = $masterDataService;
    }

    public function __invoke():bool  
    {
        // get master resource 
        $data = $this->masterDataService->getMasterResource();

        // dd($data);

        // save categories
        $this->masterDataService->storeCategory( categories: $data['categories']);

        // save brands
        $this->masterDataService->storeBrand( brands: $data['brands']);

        // save units
        $this->masterDataService->storeUnit( units: $data['units']);

        // save product types
        $this->masterDataService->storeProductType( product_types: $data['product_types']);
        
        // save attributes
        $this->masterDataService->storeAttribute( attributes: $data['attributes']);

        // save attribute options
        $this->masterDataService->storeAttributeOption( attributes_options: $data['attributes_options']);
        
        return true;
    }

}

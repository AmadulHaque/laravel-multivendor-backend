<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerAddress;
use App\Services\CustomerAddressService;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    protected $customerAddressService;
    public function __construct(CustomerAddressService $customerAddressService)
    {
        $this->customerAddressService = $customerAddressService;
    }



    public function customerAddressStore(CustomerAddress $request) : JsonResponse
    {
        $data = $request->validated();
        return $this->customerAddressService->create($data);
    }


    public function customerAddressList() : JsonResponse
    {
        return $this->customerAddressService->getAll();
    }







}

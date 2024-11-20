<?php
namespace App\Services;

use Exception;
use App\Traits\Transaction;
use App\Models\CustomerAddress;
use Illuminate\Http\JsonResponse;

class CustomerAddressService
{
    protected $model;

    public function __construct(CustomerAddress $model)
    {
        $this->model = $model;
    }


    public function getAll(): JsonResponse
    {
        try {
            $addresses = auth()->user()->addresses()
                ->with('location.parent.parent')
                ->select(
                    'id',
                    'name',
                    'landmark',
                    'address',
                    'address_type',
                    'contact_number',
                    'status',
                    'is_default_bill',
                    'is_default_ship',
                    'location_id'
                )
                ->get()
                ->map(function ($address) {
                    $city = $address->location;
                    $district = $city->parent;
                    $division = $district->parent;
                    return [
                        'id'                => $address->id,
                        'name'              => $address->name,
                        'landmark'          => $address->landmark,
                        'address'           => $address->address,
                        'address_type'      => $address->address_type,
                        'contact_number'    => $address->contact_number,
                        'status'            => $address->status,
                        'is_default_bill'   => $address->is_default_bill,
                        'is_default_ship'   => $address->is_default_ship,
                        'city'              => $city ? $city->name : null,
                        'district'          => $district ? $district->name : null,
                        'division'          => $division ? $division->name : null,
                    ];
                });

            return success('Address list', $addresses);
        } catch (Exception $e) {
            return failure('Request failed: ' . $e->getMessage(), 500);
        }
    }

    public function create(array $data = []): JsonResponse
    {
        try {
            Transaction::retryAndRollback(function () use ($data) {
                auth()->user()->addresses()->create($data);
            });
            return success('Address added successfully', [], 201);
        } catch (Exception $e) {
            return failure('Request failed: ' . $e->getMessage(), 500);
        }
    }
}

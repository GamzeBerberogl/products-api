<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductTypeRequest;
use App\Http\Requests\UpdateProductTypeRequest;
use App\Models\ProductType;
use App\Http\Resources\ProductTypeResource;


class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productType = ProductType::paginate();
        return ProductTypeResource::collection($productType);     
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $productType = new ProductType();
        $productType->fill($input)->save();
        return new ProductTypeResource($productType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductType $productType)
    {
        $input = $request->all();
        $productType->fill($input)->save();
        return new ProductTypeResource($productType);
    }
}

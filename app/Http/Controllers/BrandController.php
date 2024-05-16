<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use App\Http\Resources\BrandResource;

class BrandController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brand = Brand::paginate();
        return BrandResource::collection($brand);     
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $brand = new Brand();
        $brand->fill($input)->save();
        return new BrandResource($brand);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $input = $request->all();
        $brand->fill($input)->save();
        return new BrandResource($brand);
    }

}

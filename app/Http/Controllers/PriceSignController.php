<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePriceSignRequest;
use App\Http\Requests\UpdatePriceSignRequest;
use App\Models\PriceSign;
use App\Http\Resources\PriceSignResource;


class PriceSignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $priceSign = PriceSign::paginate();
        return PriceSignResource::collection($priceSign);     
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $priceSign = new PriceSign();
        $priceSign->fill($input)->save();
        return new PriceSignResource($priceSign);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PriceSign $priceSign)
    {
        $input = $request->all();
        $priceSign->fill($input)->save();
        return new PriceSignResource($priceSign);
    }
}

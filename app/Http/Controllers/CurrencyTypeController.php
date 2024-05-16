<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCurrencyTypeRequest;
use App\Http\Requests\UpdateCurrencyTypeRequest;
use App\Models\CurrencyType;
use App\Http\Resources\CurrencyTypeResource;


class CurrencyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencyType = CurrencyType::paginate();
        return CurrencyTypeResource::collection($currencyType);     
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $currencyType = new CurrencyType();
        $currencyType->fill($input)->save();
        return new CurrencyTypeResource($currencyType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CurrencyType $currencyType)
    {
        $input = $request->all();
        $currencyType->fill($input)->save();
        return new CurrencyTypeResource($currencyType );
    }

}

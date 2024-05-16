<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Http\Resources\CategoryResource;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::paginate();
        return CategoryResource::collection($category);     
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $category = new Category();
        $category->fill($input)->save();
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $input = $request->all();
        $category->fill($input)->save();
        return new CategoryResource($category);
    }
}

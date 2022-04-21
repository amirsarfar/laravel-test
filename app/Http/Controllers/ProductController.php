<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\EditProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::paginate(10);
    }

    public function show(Product $product)
    {
        return response()->json([$product->id => $product]);
    }

    public function store(CreateProductRequest $request)
    {
        $product = Product::create($request->all());

        return response()->json($product, 201);
    }

    public function update(EditProductRequest $request, Product $product)
    {
        $product->update($request->all());

        return response()->json($product->fresh(), 200);
    }

    public function delete(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }
}

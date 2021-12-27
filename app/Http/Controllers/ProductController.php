<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $product = $this->product->create($request->all());
            DB::commit();
            return response()->json($product, 201);
        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json($exception, 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $product = $this->product->findOrFail($id);
            $product = $product->update($request->all());
            DB::commit();
            return response()->json($product, 202);
        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json($exception, 400);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $product = $this->product->findOrFail($id);
            $product = $product->delete();
            DB::commit();
            return response()->json($product, 202);
        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json($exception, 400);
        }
    }

    public function show($id)
    {
        try {
            $product = $this->product->findOrFail($id);
            return response()->json($product, 200);
        }catch (\Exception $exception){
            return response()->json(false, 404);
        }

    }

    public function index()
    {
        $product = $this->product->all();

        return response()->json($product, 200);
    }
}

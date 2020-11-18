<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Models\Degustation;
use App\Models\Product;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Degustation $degustation
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Degustation $degustation)
    {
        return response()->json($degustation->products());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Degustation $degustation
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductStoreRequest $request, Degustation $degustation)
    {
        $product = $degustation->products()->create([
            'name' => $request->get('name')
        ]);
        $product->link = route('api.degustations.show',
            ['degustation' => $degustation->id, 'product' => $product->id]);
        return response()->json($product);
    }

    /**
     * Display the specified resource.
     *
     * @param Degustation $degustation
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Degustation $degustation, Product $product)
    {
        $product = $degustation->products()->findOrFail($product->id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Degustation $degustation
     * @param Product $product
     * @return void
     */
    public function update(ProductStoreRequest $request, Degustation $degustation, Product $product)
    {
        $degustation->products()->findOrFail($product->id)->update([
            'name' => $request->get('name')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Degustation $degustation
     * @param Product $product
     * @return void
     */
    public function destroy(Degustation $degustation, Product $product)
    {
        $degustation->products()->findOrFail($product->id)->delete();
    }
}

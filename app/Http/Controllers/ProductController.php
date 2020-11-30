<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\Degustation;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Degustation $degustation
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Degustation $degustation)
    {
        $products = $degustation->products()
            ->orderBy('created_at', 'DESC')
            ->simplePaginate(15);

        //TODO:Dodać podgląd
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //TODO:Dodać podgląd
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductController $request
     * @param Degustation $degustation
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductStoreRequest $request, Degustation $degustation)
    {
        $product = $degustation->products()->create([
            'name' => $request->get('name')
        ]);
        $product->link = route('products.show', ['degustation' => $degustation->id, 'product' => $product->id]);

        //TODO:Dodać podgląd
        return response()->json($product);
    }

    /**
     * Display the specified resource.
     *
     * @param Degustation $degustation
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Degustation $degustation, Product $product)
    {
        return response()->json(
            $degustation->products()->findOrFail($product->id)
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //TODO:Dodać podgląd
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductStoreRequest $request
     * @param Degustation $degustation
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductStoreRequest $request, Degustation $degustation, Product $product)
    {
        $degustation->products()->findOrFail($product->id)->update([
            'name' => $request->get('name')
        ]);
        return redirect()->route('products.show', ['degustation' => $degustation->id, 'product' => $product->id])
            ->with(['success' => 'Zaktualizowano produkt.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Degustation $degustation
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Degustation $degustation, Product $product)
    {
        $degustation->products()->findOrFail($product->id)->delete();
        return redirect()->route('products.index', ['degustation' => $degustation->id])
            ->with(['success' => 'Usunięto twój produkt.']);
    }
}

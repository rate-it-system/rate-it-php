<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Models\Degustation;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Degustation $degustation
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Degustation $degustation)
    {
        $user = $request->user();
        $member = $user->memberships()->select('id')->where('degustation_id', $degustation->id)->first();
        if($user->id === (int)$degustation->owner_id || $member) {
            return response()->json(
                $degustation->products()->select('id', 'name')->get()
            );
        }

        return response()->json([
            'message' => 'You do not have access to this resource.'
        ], 403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Degustation $degustation
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductStoreRequest $request, Degustation $degustation): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();

        if($user->id !== (int)$degustation->owner_id){
            return response()->json([
                'message' => 'You do not have access to this resource.'
            ], 403);
        }

        if($degustation->status !== 'created'){
            return response()->json([
                'message' => 'Cannot be edited while degustation is in progress.'
            ], 403);
        }

        $product = $degustation->products()->create([
            'name' => $request->get('name')
        ]);
        $product->link = route('api.products.show',
            ['degustation' => $degustation->id, 'product' => $product->id]);
        return response()->json($product);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Degustation $degustation
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Degustation $degustation, Product $product): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();
        $member = $user->memberships()->select('id')->where('degustation_id', $degustation->id)->first();

        if(($user->id === (int)$degustation->owner_id || $member) && $product &&
            $degustation->id === (int)$product->degustation_id) {
            return response()->json($product);
        }

        return response()->json([
            'message' => 'You do not have access to this resource.'
        ], 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Degustation $degustation
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProductStoreRequest $request, Degustation $degustation, Product $product): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();

        if($user->id !== (int)$degustation->owner_id ||
            !$product ||
            $degustation->id !== (int)$product->degustation_id){
            return response()->json([
                'message' => 'You do not have access to this resource.'
            ], 403);
        }

        if($degustation->status !== 'created'){
            return response()->json([
                'message' => 'Cannot be edited while degustation is in progress.'
            ], 403);
        }

        $product->update([
            'name' => $request->input('name')
        ]);

        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Degustation $degustation
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Degustation $degustation, Product $product): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();
        if($user->id === (int)$degustation->owner_id && $degustation->id === (int)$product->degustation_id) {
            $product->delete();
            return response()->json([
                'status' => 'ok'
            ]);
        } else if($degustation->status !== 'created'){
            return response()->json([
                'message' => 'Cannot be edited while degustation is in progress.'
            ], 403);
        } else {
            return response()->json([
                'message' => 'You do not have access to this resource.'
            ], 403);
        }
    }
}

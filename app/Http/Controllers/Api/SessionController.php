<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DegustationStoreRequest;
use App\Models\Degustation;
use App\Models\Degustationfeature;
use App\Models\Product;
use App\Models\Produktevaluations;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Class SessionController
 * @package App\Http\Controllers\Api
 */
class SessionController extends Controller
{
    /**
     * @param Degustation $degustation
     * @return \Illuminate\Http\JsonResponse
     */
    public function userReady(Degustation $degustation): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $user->degustation_id = $degustation->id;
        $user->save();
        $degustation->features = $degustation->features;
        return response()->json($degustation);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function isStarted(): \Illuminate\Http\JsonResponse
    {
        $degustation = Auth::user()->currentDegustation;
        return response()->json(['started' => ($degustation->status === 'in progress')]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentProduct(): \Illuminate\Http\JsonResponse
    {
        $degustation = Auth::user()->currentDegustation;
        $product = $degustation->currentProduct;
        $product->features = $degustation->features;
        return response()->json($product);
    }

    /**
     * @param Degustationfeature $degustationfeature
     * @param $rate
     * @return \Illuminate\Http\JsonResponse
     */
    public function rateProduct(Degustationfeature $degustationfeature, $rate): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $product = $user->currentDegustation->currentProduct;
        $produktevaluations = Produktevaluations::createOrUpdate($user, $product, $degustationfeature);

        $produktevaluations->rating = $rate;

        $produktevaluations->save();

        return response()->json($this->getProgressProduct());
    }

    /**
     * @return array
     */
    public function getProgressProduct(): array
    {
        $degustation = Auth::user()->currentDegustation;
        $product = $degustation->currentProduct;
        return [
            'total' => $degustation->members->count(),
            'progress' => Produktevaluations::where('product_id', $product->id)->count()
        ];
    }

    public function nextProduct(): \Illuminate\Http\JsonResponse
    {
        $degustation = Auth::user()->currentDegustation;
        $current_product = $degustation->currentProduct;
        $nextIsNewProduct = false;
        foreach ($degustation->products as $product) {
            if($nextIsNewProduct){
                $degustation->product_id = $product->id;
                break;
            }
            $degustation->product_id = null;
            if ($product->id === $current_product->id) {
                $nextIsNewProduct = true;
            }
        }

        if($degustation->product_id === null){
            $degustation->status = "completed";
        }

        $degustation->save();
        return response()->json(Product::find($degustation->product_id));
    }

    public function start()
    {
        $degustation = Auth::user()->currentDegustation;
        $degustation->product_id = $degustation->products->first()->id;
        $degustation->status = 'in progress';
        $degustation->save();
    }
}

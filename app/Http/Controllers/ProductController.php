<?php

namespace App\Http\Controllers;

use App\Models\Degustation;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Degustation $degustation)
    {
        return response(
            $degustation->products()
        );
    }
}

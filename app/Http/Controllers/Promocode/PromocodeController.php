<?php

namespace App\Http\Controllers\Promocode;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Promocode\Promocode;

class PromocodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web,admin');
    }
    
    public function index(Request $request)
    {
        $data = Promocode::where('promocode', $request->voucherCode)->where('status', 1)->first();
        return $data;
    }
}

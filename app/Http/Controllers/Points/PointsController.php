<?php

namespace App\Http\Controllers\Points;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Loyaltypoints\Checkpoints;

class PointsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api,admin']);
    }

    public function index(Checkpoints $points)
    {
        $response = $points->Checkpoints(intval(request()->user()->phone));
        return response()->json($response);
    }
}

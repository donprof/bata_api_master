<?php

namespace App\Http\Controllers\Logs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Logs\Logs;

class LogsController extends Controller
{
    public function index(Request $request)
    {
        $logs = Logs::logs();
        return response($logs);
    }
}

<?php

namespace App\Http\Controllers\Backstage;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('backstage.dashboard.index');
    }
}

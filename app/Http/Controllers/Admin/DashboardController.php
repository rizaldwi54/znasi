<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('Content.admin.dashboard');
    }

    public function dash(): View
    {
        return view('Content.admin.dash');
    }
}


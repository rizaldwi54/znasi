<?php

namespace App\Http\Controllers\User;

use App\Models\Spot;
use Illuminate\View\View;
use App\Models\CenterPoint;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Routing\Controller;

class UserDashboardController extends Controller
{
    public function index(): View
    {
        return view('Content.user.dashboard');
    }

    public function spots()
    {
        $centerPoint = CenterPoint::get()->first();
        $spot = Spot::get();

        return view('Content.user.index',[
            'CenterPoint' => $centerPoint,
            'spot' => $spot
        ]);
    }

    public function detailSpot($slug)
    {
        $spot = Spot::where('slug',$slug)->first();
        return view('Content.user.detail', ['spot' => $spot]);
    }
}

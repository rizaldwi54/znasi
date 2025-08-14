<?php

namespace App\Http\Controllers\User;

use App\Models\Spot;
use App\Models\User;
use Illuminate\View\View;
use App\Models\CenterPoint;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index(): View
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('Content.user.dashboard', compact('profileData'));
    }

    public function spots()
    {
        $centerPoint = CenterPoint::get()->first();
        $spot = Spot::get();

        return view('Content.user.index',[
            'centerPoint' => $centerPoint,
            'spot' => $spot
        ]);
    }

    public function detailSpot($slug)
    {
        $spot = Spot::where('slug',$slug)->first();
        return view('Content.user.detail', ['spot' => $spot]);
    }

    public function registrasi()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('Content.user.pendaftaran' , compact('profileData'));
    }

    
}

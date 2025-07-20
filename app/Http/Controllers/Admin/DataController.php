<?php

namespace App\Http\Controllers\Admin;

use App\Models\Spot;
use App\Models\CenterPoint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function centerpoint()
    {
        $centerPoint = CenterPoint::latest()->get();

        return datatables()->of($centerPoint)
        ->addColumn('action' , 'Content.admin.action')
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->toJson();
        
    }

    /**
     * Show the list of spots in datatable
     *
     * @return \Illuminate\Http\Response
     */
    public function spot()
    {
        $spot = Spot::latest()->get();
        
        return datatables()->of($spot)
        ->addColumn('action' , 'Content.spot.action')
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->toJson();
    }
}

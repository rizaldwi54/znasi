<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use App\Models\CenterPoint;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Routing\Controller;




class CenterPointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Content.admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Content.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'coordinate' => 'required',
        ]);

        

        $centerPoint = new CenterPoint();
        $centerPoint->coordinates = $request->input('coordinate');
        $centerPoint->save();

        if ($centerPoint) {
            return to_route('center-point.index')->with('success', 'Data berhasil disimpan');
        } else {
            return to_route('center-point.index')->with('error', 'Data gagal disimpan');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CenterPoint $centerPoint)
    {
        $centerPoint = CenterPoint::findOrFail($centerPoint->id);
        return view('Content.admin.edit', ['CenterPoint' => $centerPoint]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CenterPoint $centerPoint)
    {
        $centerPoint = CenterPoint::findOrFail($centerPoint->id);
        $centerPoint->coordinates = $request->input('coordinate');
        $centerPoint->update();

        // if ($CenterPoint) {
        //     return to_route('center-point.index')->with('success', 'Data berhasil diupdate');
        // } else {
        //     return to_route('center-point.index')->with('error', 'Data gagal diupdate');
        // }
        return redirect()->route('center-point.index')->with(
            $centerPoint->wasChanged() ? 'success' : 'info',
            $centerPoint->wasChanged() ? 'Data berhasil diupdate' : 'Tidak ada perubahan data'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $centerPoint = CenterPoint::findOrFail($id);
        $centerPoint->delete();
        return redirect()->back();
    }

    public function data()
    {
        $centerPoints = CenterPoint::all();

        return DataTables::of($centerPoints)
            ->addIndexColumn() // This adds the DT_RowIndex
            ->addColumn('action', function ($row) {
                // Your action buttons here
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Spot;
use App\Models\centerPoint;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SpotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Content.spot.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $centerPoint = centerPoint::get()->first();
        return view('Content.spot.create', ['centerPoint' => $centerPoint]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'coordinate' => 'required',
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $spot = new Spot;
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $uploadFile = $image->hashName();
            $image->move('upload/image/', $uploadFile);
            $spot->image = $uploadFile;

            // $image = $request->file('image');
            // $file->storeAs('public/Image', $i->hashName());
            // $spot->image = $file->hashName();

            // $image = $request->file('image');
            // $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            // Storage::disk('public')->putFileAs('Image', $image, $imageName);
            // // $spot->image = $imageName;
            // $newRequest = $request->all();
            // $newRequest['image'] = $imageName;


        }

        $spot->name = $request->input('name');
        $spot->slug = Str::slug($request->name, '-');
        $spot->description = $request->input('description');
        $spot->coordinates = $request->input('coordinate');
        $spot->save();


        if ($spot) {
            return to_route('spot.index')->with('success', 'Data berhasil disimpan');
        } else {
            return to_route('spot.index')->with('error', 'Data gagal disimpan');
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
    public function edit(Spot $spot)
    {
        $centerPoint = centerPoint::get()->first();
        // Fetch the spot by ID
        return view('Content.spot.edit', [
            'centerPoint' => $centerPoint,
            'spot' => $spot
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Spot $spot)
    {
        $request->validate([
            'coordinate' => 'required',
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Hapus File image pada folder public/upload/spots
            if (File::exists('upload/image/' . $spot->image)) {
                File::delete('upload/image/' . $spot->image);
            }

            // Proses Upload File image ke folder public/upload/spots
            $image = $request->file('image');
            $uploadFile = $image->hashName();
            $image->move('upload/image/', $uploadFile);
            $spot->image = $uploadFile;

            // Proses hapus & Upload File image ke folder public/upload/spots
            // Storage::disk('local')->delete('public/spots/' . $spot->image);
            // $file = $request->file('image');
            // $file->storeAs('public/ImageSpot', $file->hashName());
            // $spot->image = $file->hashName();
        }
        $spot->name = $request->input('name');
        $spot->slug = Str::slug($request->name, '-');
        $spot->description = $request->input('description');
        $spot->coordinates = $request->input('coordinate');
        $spot->update();


        if ($spot) {
            return to_route('spot.index')->with('success', 'Data berhasil diupdate');
        } else {
            return to_route('spot.index')->with('error', 'Data gagal diupdate');
        }
        // return redirect()->route('spot.index')->with(
        //     $spot->wasChanged() ? 'success' : 'info',
        //     $spot->wasChanged() ? 'Data berhasil diupdate' : 'Tidak ada perubahan data'
        // );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $spot = Spot::findOrFail($id);
        if (File::exists('upload/image/' . $spot->image)) {
            File::delete('upload/image/' . $spot->image);
        }
        $spot->delete();
        return redirect()->back();
    }

    public function data()
    {
        $spot = Spot::all();

        return DataTables::of($spot)
            ->addIndexColumn() // This adds the DT_RowIndex
            ->addColumn('action', function ($row) {
                // Your action buttons here
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}

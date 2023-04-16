<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\HotelImage;
use Illuminate\Http\Request;

class HotelImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($hotelId)
    {
        $hotel = Hotel::findOrFail($hotelId);
        $breadcrumbs = [
            ['route' => '', 'name' => 'Hotel Management'],
            ['route' => '', 'name' => 'Image Management'],
        ];
        return view('hotel-image.main', [
            'title' => $hotel->name . ' Image Management',
            'breadcrumbs' => $breadcrumbs,
            'hotel' => $hotel,
            'data' => HotelImage::where('hotelId', $hotelId)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $this->validate(
        //     $request,
        //     [
        //         'image[]' => 'required|mimes:jpeg,jpg,png,webp',
        //     ],
        //     [
        //         'image[].required' => 'Please select image',
        //         'image[].mimes' => 'Only jpeg,jpg,png,webp file type is supported.',
        //     ]
        // );

        if ($request->hasfile('image')) {

            foreach ($request->file('image') as $image) {
                $data = new HotelImage($request->all());
                $data->save();

                $file = $image;
                $image_url = $file->store('hotel/' . $data->hotelId, 'public');

                // !update image url
                $data->image_url = config('app.url') . "/storage/" . $image_url;
                $data->save();
            }
            return redirect()->route('hotels-image.index', ['hotelId' => $request->hotelId])->with('toast_success', 'Create data succeed!');
        }

        return redirect()->route('hotels-image.index', ['hotelId' => $request->hotelId]);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $data = HotelImage::findOrFail($id);

        // old data
        $inHotel = HotelImage::where(['hotelId' => $data->hotelId, 'is_cover' => true])->first();
        if ($inHotel != null) {
            $inHotel->is_cover = false;
            $inHotel->save();
        }
        // update data
        $data->update($request->all());
        $data->save();


        return redirect()->route('hotels-image.index', ['hotelId' => $data->hotelId])->with('toast_success', 'Update data succeed!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = HotelImage::findOrFail($id);
        $data->delete();
        return back()->with('toast_success', 'Delete data succeed!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['route' => '', 'name' => 'Setting'],
        ];
        return view('setting.main', [
            'title' => 'Setting',
            'breadcrumbs' => $breadcrumbs,
            'data' => Setting::first(),
            'quote' => Setting::where('key', 'config-quote')->first(),
            'aboutus' => Setting::where('key', 'config-aboutus')->first(),
            'facebook' => Setting::where('key', 'config-facebook')->first(),
            'twitter' => Setting::where('key', 'config-twitter')->first(),
            'line' => Setting::where('key', 'config-line')->first(),
            'youtube' => Setting::where('key', 'config-youtube')->first(),
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
        //
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
        switch ($request->action) {
            case 'social':
                $facebook = Setting::where('key', 'config-facebook')->first();
                $facebook->value = $request->facebook;
                $facebook->save();

                $twitter = Setting::where('key', 'config-twitter')->first();
                $twitter->value = $request->twitter;
                $twitter->save();

                $line = Setting::where('key', 'config-line')->first();
                $line->value = $request->line;
                $line->save();

                $youtube = Setting::where('key', 'config-youtube')->first();
                $youtube->value = $request->youtube;
                $youtube->save();
                break;

            default:
                $data = Setting::findOrFail($id);
                $data->update($request->all());
                $data->save();
                break;
        }

        return redirect()->route('settings.index')->with('toast_success', 'Update data succeed!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

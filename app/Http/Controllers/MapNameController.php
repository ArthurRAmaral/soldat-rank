<?php

namespace App\Http\Controllers;

use App\Models\MapName;
use Illuminate\Http\Request;

class MapNameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maps = MapName::all();

        return view('pages.map.index', [
            'maps' => $maps
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $maps = MapName::all();

        return view('pages.map.create', [
            'maps' => $maps
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MapName  $mapName
     * @return \Illuminate\Http\Response
     */
    public function show(MapName $mapName)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MapName  $mapName
     * @return \Illuminate\Http\Response
     */
    public function edit(MapName $mapName)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MapName  $mapName
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MapName $mapName)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MapName  $mapName
     * @return \Illuminate\Http\Response
     */
    public function destroy(MapName $mapName)
    {
        //
    }
}

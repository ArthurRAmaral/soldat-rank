<?php

namespace App\Http\Controllers;

use App\Models\Championship;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChampionshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.championship.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.championship.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //changing date format
        
 
        $validated = $request->validate([
            'title' => 'required|unique:championships|max:255',
            'game_mode' => 'required|max:255',
            'end' => 'required|date_format:d-m-Y'
        ]);
        $validated['end'] = Carbon::parse($request->end)->format('Y-m-d');

        $championship = new Championship;
        $championship->title = $validated['title'];
        $championship->game_mode = $validated['game_mode'];
        $championship->start = Carbon::now()->format('Y-m-d');
        $championship->end = $validated['end'];

        $championship->save();
        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Championship  $championship
     * @return \Illuminate\Http\Response
     */
    public function show(Championship $championship)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Championship  $championship
     * @return \Illuminate\Http\Response
     */
    public function edit(Championship $championship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Championship  $championship
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Championship $championship)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Championship  $championship
     * @return \Illuminate\Http\Response
     */
    public function destroy(Championship $championship)
    {
        //
    }
}

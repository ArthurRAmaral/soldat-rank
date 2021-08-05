<?php

namespace App\Http\Controllers;

use App\Models\Championship;
use App\Models\GameMatch;
use App\Models\User;
use Illuminate\Http\Request;

class GameMatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $championships = Championship::all();
        $players = User::all();

        return view('pages.game_match.create', [
            'championships' => $championships,
            'players' => $players
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
     * @param  \App\Models\GameMatch  $gameMatch
     * @return \Illuminate\Http\Response
     */
    public function show(GameMatch $gameMatch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GameMatch  $gameMatch
     * @return \Illuminate\Http\Response
     */
    public function edit(GameMatch $gameMatch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GameMatch  $gameMatch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GameMatch $gameMatch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GameMatch  $gameMatch
     * @return \Illuminate\Http\Response
     */
    public function destroy(GameMatch $gameMatch)
    {
        //
    }
}

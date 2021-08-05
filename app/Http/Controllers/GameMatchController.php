<?php

namespace App\Http\Controllers;

use App\Models\Championship;
use App\Models\GameMatch;
use App\Models\User;
use Carbon\Carbon;
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

        $request->validate([
            'championship_id' => 'required|integer',
            'player1' => 'required|string|max:255',
            'player2' => 'required|string|max:255',
            'img_1' => 'required|string|max:255',
            'img_2' => 'required|string|max:255',
            'img_3' => 'required|string|max:255',
            'match_date' => 'required|date_format:d-m-Y'
        ]);

        //$maps = array($request->img_1, $request->img_2, $request->img_3);
        $maps = json_encode([$request->img_1, $request->img_2, $request->img_3]);
        //$competitors = array($request->player1, $request->player2);
        $competitors = json_encode([$request->player1, $request->player2]);
       
        $match_date = Carbon::parse($request->match_date)->format('Y-m-d');

        $game_match = new GameMatch();
        $game_match->championship_id = $request->championship_id;
        $game_match->competitors = $competitors;
        $game_match->img = $maps;
        $game_match->match_date = $match_date;

        if($request->draw){
            $game_match->draw = true;
        }else{
            $game_match->draw = false;
            $game_match->winner = $request->player1;
            $game_match->loser = $request->player2;
        }
        
        $game_match->save();
        return redirect('/home');
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

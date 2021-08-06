<?php

namespace App\Http\Controllers;

use App\Models\Championship;
use App\Models\Clan;
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

    public function chooseGameModePage(){
        $championships = Championship::all();

        return view('pages.game_match.choose_mode', [
            'championships' => $championships,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        $championship = Championship::find($request->championship_id);

        $draw = null;
        $label1 = null;
        $label2 = null;
        if($request->draw){
            $draw = true;
            $label1 = "Adversário 1";
            $label2 = "Adversário 2";
        }else{
            $draw = false;
            $label1 = "Vencedor";
            $label2 = "Perdedor";
        }

        //if cf, then show only clans in select options and pass the apropriate labels
        if($championship->game_mode === 'cf'){
            $clans = Clan::all();
            return view("pages.game_match.create", [
                'competitors' => $clans,
                'championship' => $championship,
                'draw' => $draw,
                'label1' => $label1,
                'label2' => $label2
            ]);
        //if x1, then show only players in select options and pass the apropriate labels
        }else { 
            $players = User::all();
            return view("pages.game_match.create", [
                'competitors' => $players,
                'championship' => $championship,
                'draw' => $draw,
                'label1' => $label1,
                'label2' => $label2
            ]);
        }
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
            'competitor1' => 'required|string|max:255',
            'competitor2' => 'required|string|max:255',
            'img_1' => 'required|string|max:255',
            'img_2' => 'required|string|max:255',
            'img_3' => 'required|string|max:255',
            'match_date' => 'required|date_format:d-m-Y'
        ]);
       

        //it must be a json data to be added in the DB
        $maps = json_encode([$request->img_1, $request->img_2, $request->img_3]);
        $competitors = json_encode([$request->competitor1, $request->competitor2]);

       //DB date format
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
            $game_match->winner = $request->competitor1;
            $game_match->loser = $request->competitor2;
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

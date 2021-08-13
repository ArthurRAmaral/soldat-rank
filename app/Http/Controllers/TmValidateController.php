<?php

namespace App\Http\Controllers;

use App\Models\GameMatch;
use App\Models\Map;
use Illuminate\Http\Request;

class TmValidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rank_id = getCurrentRankId('TM');
        //get only the non validated matches
        $notValidatedGameMatches = GameMatch::where('rank_id', $rank_id)
                                            ->where('is_validated', null)
                                            ->leftJoin('clans as winner', 'game_matches.winner', '=', 'winner.id')
                                            ->leftJoin('clans as loser', 'game_matches.loser', '=', 'loser.id')
                                            ->select('winner.name as winnerName', 'loser.name as loserName',
                                                    'game_matches.id as matchId', 'game_matches.match_date', 'game_matches.draw')
                                            ->orderBy('game_matches.match_date', 'asc') //olders first
                                            ->get();
        
        //get the 3 maps related with each game_match
        $setOfMaps = array();
        foreach($notValidatedGameMatches as $match){
            $maps = Map::where('game_match_id', $match->matchId)
                        ->orderBy('maps.id', 'asc')
                        ->get();

            array_push($setOfMaps, $maps);
        }
        
        return view('pages.game_match.tm.validate', [
            'matches' => $notValidatedGameMatches,
            'setOfMaps' => $setOfMaps
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   $matchId = null;
        if($request->accept){
            $gameMatch = GameMatch::findOrFail($request->accept);
            $gameMatch->is_validated = 1;
        }else if($request->refuse){
            $gameMatch = GameMatch::findOrFail($request->refuse);
            $gameMatch->is_validated = 0;
        }else{
            abort(404, "Unexpected!");
        }

        updateMatchHistory($gameMatch->winner, $gameMatch->loser, $gameMatch->game_mode, $gameMatch->draw);

        $gameMatch->save();
        return redirect()->route('tm_validate');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

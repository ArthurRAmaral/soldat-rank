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
                                            ->leftJoin('maps as map1', 'game_matches.id', '=', 'map1.game_match_id')
                                            ->where('map1.order', 1)
                                            ->leftJoin('map_names as map_name1', 'map1.map_name_id', '=', 'map_name1.id')
                                            ->leftJoin('maps as map2', 'game_matches.id', '=', 'map2.game_match_id')
                                            ->where('map2.order', 2)
                                            ->leftJoin('map_names as map_name2', 'map2.map_name_id', '=', 'map_name2.id')
                                            ->leftJoin('maps as map3', 'game_matches.id', '=', 'map3.game_match_id')
                                            ->where('map3.order', 3)
                                            ->leftJoin('map_names as map_name3', 'map3.map_name_id', '=', 'map_name3.id')
                                            ->leftJoin('users as submitter', 'submitter.id', '=', 'game_matches.submitted_by')
                                            ->select('winner.name as winnerName', 'loser.name as loserName',
                                                    'game_matches.id as matchId', 'game_matches.match_date',
                                                    'game_matches.total_score_winner', 'game_matches.total_score_loser',
                                                    'map1.screen as screen1', 'map2.screen as screen2', 'map3.screen as screen3',
                                                    'map1.score_winner as score_winner1', 'map1.score_loser as score_loser1',
                                                    'map2.score_winner as score_winner2', 'map2.score_loser as score_loser2',
                                                    'map3.score_winner as score_winner3', 'map3.score_loser as score_loser3',
                                                    'game_matches.submitter_comment', 'submitter.name as submitterName',
                                                    'submitter.nickname as submitterNickname', 'game_matches.created_at as created_match_date',
                                                    'game_matches.submitted_date as submitted_match_date', 'game_matches.delta_winner',
                                                    'game_matches.delta_loser', 'submitter.id as submitterId', 'winner.id as winnerId',
                                                    'loser.id as loserId', 'map_name1.name as mapName1', 'map_name2.name as mapName2',
                                                    'map_name3.name as mapName3')
                                            ->orderBy('game_matches.updated_at', 'desc') //latests first
                                            ->paginate(5);
        

        return view('pages.game_match.tm.validate', [
            'matches' => $notValidatedGameMatches,
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

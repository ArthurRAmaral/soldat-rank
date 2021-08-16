<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use App\Models\GameMatch;
use App\Models\Map;
use App\Models\MapName;
use App\Models\MatchHistory;
use App\Models\Rank;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameMatchTmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rank_id = getCurrentRankId('TM');
        //get only validated matches
        $validatedGameMatches = GameMatch::where('rank_id', $rank_id)
                                            ->where('is_validated', 1)
                                            ->leftJoin('clans as winner', 'game_matches.winner', '=', 'winner.id')
                                            ->leftJoin('clans as loser', 'game_matches.loser', '=', 'loser.id')
                                            ->select('winner.name as winnerName', 'loser.name as loserName',
                                                    'game_matches.id as matchId', 'game_matches.match_date')
                                            ->orderBy('game_matches.updated_at', 'desc') //latests first
                                            ->get();
        
        //get the 3 maps related with each game_match
        $setOfMaps = array();
        foreach($validatedGameMatches as $match){
            $maps = Map::where('game_match_id', $match->matchId)
                        ->orderBy('maps.id', 'asc')
                        ->get();

            array_push($setOfMaps, $maps);
        }
        
        return view('pages.game_match.tm.index', [
            'matches' => $validatedGameMatches,
            'setOfMaps' => $setOfMaps
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rank(){
        $rankId = getCurrentRankId('TM');
        $matchHistories = MatchHistory::where('game_mode', 'TM')
                                        ->where('rank_id', $rankId)
                                        ->leftJoin('clans', 'match_histories.competitor_id', '=', 'clans.id')
                                        ->select('match_histories.points', 'match_histories.wins', 'match_histories.losses', 
                                                'match_histories.draws', 'clans.name')
                                        ->orderBy('points', 'desc')
                                        ->get();

        return view('pages.game_match.tm.rank', [
            'matchHistories' => $matchHistories
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dateNow = Carbon::now('America/Sao_Paulo')->format('Y-m-d');
        $clans = Clan::where('id', '<>', Auth::user()->clan_id)->get(); //get all, but not the auth user clan
        $map_names = MapName::all();
        $playerClan = Clan::find(Auth::user()->clan_id); //get only auth user clan


        return view('pages.game_match.tm.create', [
            'dateNow' => $dateNow,
            'clans' => $clans,
            'playerClan' => $playerClan,
            'map_names' => $map_names,
            
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
        //get the current active tm rank
        $rank_id = getCurrentRankId('TM');

        /** COPIED */

        //get winner and loser or draw by calculating the total points of each player
        $clan1MatchPoints = $request->clan1_points_map1 + $request->clan1_points_map2 + $request->clan1_points_map3;
        $clan2MatchPoints = $request->clan2_points_map1 + $request->clan2_points_map2 + $request->clan2_points_map3;
        $winnerId = null;
        $loserId = null;
        $draw = null;
        $winnerMatchScore = null;
        $loserMatchScore = null;
        //if clan1 points is greater than clan2 points than clan1 is setted as winner and player 2 as loser
        //the same logic goes on in the following conditional statements
        if($clan1MatchPoints > $clan2MatchPoints){
            $winnerId = $request->clan1;
            $loserId = $request->clan2;
            $winnerMatchScore = $clan1MatchPoints;
            $loserMatchScore = $clan2MatchPoints;
        }else if ($clan1MatchPoints < $clan2MatchPoints){
            $winnerId = $request->clan2;
            $loserId = $request->clan1;
            $winnerMatchScore = $clan2MatchPoints;
            $loserMatchScore = $clan1MatchPoints;
        }else{
            $winnerId = $request->clan1;
            $loserId = $request->clan2;
            $winnerMatchScore = $clan1MatchPoints;
            $loserMatchScore = $clan2MatchPoints;
            $draw = 1;
        }
        
        

        //get total games from winner and points
        $winnerHistory = MatchHistory::where('competitor_id', $winnerId)
                                     ->where('game_mode', 'TM')->first();
        $gamesWinner = $winnerHistory->wins + $winnerHistory->losses + $winnerHistory->draws;
        $winnerTotalPoints = $winnerHistory->points;
        //get total games from loser
        $loserHistory = MatchHistory::where('competitor_id', $loserId)
                                    ->where('game_mode', 'TM')->first();
        $gamesLoser = $loserHistory->wins + $loserHistory->losses + $loserHistory->draws;
        $loserTotalPoints = $loserHistory->points;

        //GET NEW TOTAL POINTS FROM ELO FUNCTION and get deltaWinner and deltaLoser
        $deltaResults = elo($winnerTotalPoints, $loserTotalPoints, $gamesWinner, $gamesLoser, $draw);

        //$winnerNewTotalPoints = $deltaResults['winnerNewTotalPoints'];
        //$loserNewTotalPoints = $deltaResults['loserNewTotalPoints'];
        $deltaWinner = $deltaResults['deltaWinner'];
        $deltaLoser = $deltaResults['deltaLoser'];

        /**COPIED */

        //get user who submitted the match
        $submittedBy = Auth::id();

        //ADDING DATA TO GAME-MATCH
        $matchDate = Carbon::parse($request->match_date)->format('Y-m-d');
        //saving data to new gameMatch row
        $gameMatch = new GameMatch();
        $gameMatch->rank_id = $rank_id;
        $gameMatch->game_mode = "TM";
        $gameMatch->winner = $winnerId;
        $gameMatch->loser = $loserId;
        $gameMatch->total_score_winner = $winnerMatchScore;
        $gameMatch->total_score_loser = $loserMatchScore;
        $gameMatch->delta_winner = $deltaWinner;
        $gameMatch->delta_loser = $deltaLoser;
        $gameMatch->draw = $draw;
        $gameMatch->submitted_by = $submittedBy;
        $gameMatch->submitter_comment = $request->comment;
        $gameMatch->match_date = $matchDate;
        $gameMatch->submitted_date = $matchDate;
        //saving gameMatch first in order to get the id to pass in map FK game_match_id
        $gameMatch->save();

        //renaming images and storing it on public dir, returning it's new names to be stored on DB
        $imagesName = saveMapImages($request);

        //storing the 3 map datas
        Map::create([
            'game_match_id' => $gameMatch->id,
            'map_name_id' => $request->name_map1,
            'screen' => $imagesName[0],
            'score_winner' => $request->clan1_points_map1,
            'score_loser' => $request->clan2_points_map1
        ]);
        Map::create([
            'game_match_id' => $gameMatch->id,
            'map_name_id' => $request->name_map2,
            'screen' => $imagesName[1],
            'score_winner' => $request->clan1_points_map2,
            'score_loser' => $request->clan2_points_map2
        ]);
        Map::create([
            'game_match_id' => $gameMatch->id,
            'map_name_id' => $request->name_map3,
            'screen' => $imagesName[2],
            'score_winner' => $request->clan1_points_map3,
            'score_loser' => $request->clan2_points_map3
        ]);
        

        return redirect('/home');
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

<?php

namespace App\Http\Controllers;

use App\Models\GameMatch;
use App\Models\Map;
use App\Models\MapName;
use App\Models\MatchHistory;
use App\Models\Rank;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameMatchDmController extends Controller
{

    public function test(){
        $validatedGameMatches = GameMatch::where('rank_id', 1)
                                            ->where('is_validated', 1)
                                            ->leftJoin('users as winner', 'game_matches.winner', '=', 'winner.id')
                                            ->leftJoin('users as loser', 'game_matches.loser', '=', 'loser.id')
                                            ->leftJoin('maps as map1', 'game_matches.id', '=', 'map1.game_match_id')
                                            ->where('map1.order', 1)
                                            ->leftJoin('maps as map2', 'game_matches.id', '=', 'map2.game_match_id')
                                            ->where('map2.order', 2)
                                            ->leftJoin('maps as map3', 'game_matches.id', '=', 'map3.game_match_id')
                                            ->where('map3.order', 3)
                                            ->select('winner.nickname as winnerName', 'loser.nickname as loserName',
                                                    'game_matches.id as matchId', 'game_matches.match_date',
                                                    'game_matches.total_score_winner', 'game_matches.total_score_loser',
                                                    'map1.screen as screen1', 'map2.screen as screen2', 'map3.screen as screen3',
                                                    'map1.score_winner as score_winner1', 'map1.score_loser as score_loser1',
                                                    'map2.score_winner as score_winner2', 'map2.score_loser as score_loser2',
                                                    'map3.score_winner as score_winner3', 'map3.score_loser as score_loser3')
                                            ->orderBy('game_matches.updated_at', 'desc') //latests first
                                            ->get();

                                            dd($validatedGameMatches);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rank_id = getCurrentRankId('DM');
        //get only validated matches
        $validatedGameMatches = GameMatch::where('rank_id', $rank_id)
                                            ->where('is_validated', 1)
                                            ->leftJoin('users as winner', 'game_matches.winner', '=', 'winner.id')
                                            ->leftJoin('users as loser', 'game_matches.loser', '=', 'loser.id')
                                            ->leftJoin('maps as map1', 'game_matches.id', '=', 'map1.game_match_id')
                                            ->where('map1.order', 1)
                                            ->leftJoin('maps as map2', 'game_matches.id', '=', 'map2.game_match_id')
                                            ->where('map2.order', 2)
                                            ->leftJoin('maps as map3', 'game_matches.id', '=', 'map3.game_match_id')
                                            ->where('map3.order', 3)
                                            ->select('winner.nickname as winnerName', 'loser.nickname as loserName',
                                                    'game_matches.id as matchId', 'game_matches.match_date',
                                                    'game_matches.total_score_winner', 'game_matches.total_score_loser',
                                                    'map1.screen as screen1', 'map2.screen as screen2', 'map3.screen as screen3',
                                                    'map1.score_winner as score_winner1', 'map1.score_loser as score_loser1',
                                                    'map2.score_winner as score_winner2', 'map2.score_loser as score_loser2',
                                                    'map3.score_winner as score_winner3', 'map3.score_loser as score_loser3')
                                            ->orderBy('game_matches.updated_at', 'desc') //latests first
                                            ->paginate(5);

        
        return view('pages.game_match.dm.index', [
            'matches' => $validatedGameMatches,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rank(){
        $rankId = getCurrentRankId('DM');
        $matchHistories = MatchHistory::where('game_mode', 'DM')
                                        ->where('rank_id', $rankId)
                                        ->whereColumn('match_histories.created_at', '<>', 'match_histories.updated_at')
                                        ->leftJoin('users', 'match_histories.competitor_id', '=', 'users.id')
                                        ->select('match_histories.points', 'match_histories.wins', 'match_histories.losses', 
                                                'match_histories.draws', 'users.nickname', 'users.id as userId')
                                        ->orderBy('points', 'desc')
                                        ->get();

        return view('pages.game_match.dm.rank', [
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
        $players = User::where('id', '<>', Auth::user()->id)->get();
        $map_names = MapName::orderBy('name', 'asc')->get();

        return view('pages.game_match.dm.create', [
            'dateNow' => $dateNow,
            'players' => $players,
            'currentPlayer' => Auth::user(),
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

        $request->validate([
            'player1_points_map1' => 'required|integer',
            'player1_points_map2' => 'required|integer',
            'player2_points_map1' => 'required|integer',
            'player2_points_map2' => 'required|integer',
            'player1' => 'required|integer',
            'player2' => 'required|integer',
            'name_map1' => 'required|string|max:255',
            'name_map2' => 'required|string|max:255',
            'img_1' => 'required|mimes:jpg,png,jpeg|max:5048',
            'img_2' => 'required|mimes:jpg,png,jpeg|max:5048',
            'match_date' => 'required',
        ]);

        //get the current active dm rank
        $rank_id = getCurrentRankId('DM');

        /** COPIED */

        //get winner and loser or draw by calculating the total points of each player
        $player1MatchPoints = $request->player1_points_map1 + $request->player1_points_map2 + $request->player1_points_map3;
        $player2MatchPoints = $request->player2_points_map1 + $request->player2_points_map2 + $request->player2_points_map3;
        $winnerId = null;
        $loserId = null;
        $draw = null;
        $winnerMatchScore = null;
        $loserMatchScore = null;
        //if player1 points is greater than player2 points than player1 is setted as winner and player 2 as loser
        //the same logic goes on in the following conditional statements
        if($player1MatchPoints > $player2MatchPoints){
            $winnerId = $request->player1;
            $loserId = $request->player2;
            $winnerMatchScore = $player1MatchPoints;
            $loserMatchScore = $player2MatchPoints;
        }else if ($player1MatchPoints < $player2MatchPoints){
            $winnerId = $request->player2;
            $loserId = $request->player1;
            $winnerMatchScore = $player2MatchPoints;
            $loserMatchScore = $player1MatchPoints;
        }else{
            $winnerId = $request->player1;
            $loserId = $request->player2;
            $winnerMatchScore = $player1MatchPoints;
            $loserMatchScore = $player2MatchPoints;
            $draw = 1;
        }
        
        

        //get total games from winner and points
        $winnerHistory = MatchHistory::where('competitor_id', $winnerId)
                                     ->where('game_mode', 'DM')->first();
        $gamesWinner = $winnerHistory->wins + $winnerHistory->losses + $winnerHistory->draws;
        $winnerTotalPoints = $winnerHistory->points;
        //get total games from loser
        $loserHistory = MatchHistory::where('competitor_id', $loserId)
                                    ->where('game_mode', 'DM')->first();
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
        $gameMatch->game_mode = "DM";
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
            'score_winner' => $request->player1_points_map1,
            'score_loser' => $request->player2_points_map1,
            'order' => 1
        ]);
        Map::create([
            'game_match_id' => $gameMatch->id,
            'map_name_id' => $request->name_map2,
            'screen' => $imagesName[1],
            'score_winner' => $request->player1_points_map2,
            'score_loser' => $request->player2_points_map2,
            'order' => 2
        ]);
        Map::create([
            'game_match_id' => $gameMatch->id,
            'map_name_id' => $request->name_map3,
            'screen' => $imagesName[2],
            'score_winner' => $request->player1_points_map3,
            'score_loser' => $request->player2_points_map3,
            'order' => 3
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

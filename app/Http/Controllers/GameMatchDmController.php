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
        $dateNow = Carbon::now('America/Sao_Paulo')->format('Y-m-d');
        $players = User::all();
        $map_names = MapName::all();

        return view('pages.game_match.dm.create', [
            'dateNow' => $dateNow,
            'players' => $players,
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
        //get the current active dm rank
        $rank_id = Rank::select('id')
                        ->where('is_active', 1)
                        ->where('game_mode', 'DM')
                        ->first();

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

        //get new total points from elo function and get deltaWinner and deltaLoser
        $deltaResults = elo($winnerTotalPoints, $loserTotalPoints, $gamesWinner, $gamesLoser, $draw);
        $winnerNewTotalPoints = $deltaResults['winnerNewTotalPoints'];
        $loserNewTotalPoints = $deltaResults['loserNewTotalPoints'];
        $deltaWinner = $deltaResults['deltaWinner'];
        $deltaLoser = $deltaResults['deltaLoser'];

        //get user who submitted the match
        $submittedBy = Auth::id();

        /* ------- ADDING DATA TO MATCH HISTORY  ------*/
        //calculating new total draws, wins or losses
        $oneMoreWin = null;
        $oneMoreDraw = null;
        $oneMoreLoss = null;
        if(!$draw){
            $oneMoreWin = 1;
            $oneMoreLoss = 1;
            $oneMoreDraw = 0;
        }else{
            $oneMoreWin = 0;
            $oneMoreLoss = 0;
            $oneMoreDraw = 1;
        }
        //case player had won, then sum +1 to the total wins
        //case player had draw, then sum +1 to the total draws
        $totalWins = $winnerHistory->wins + $oneMoreWin;
        $totalDraws1 = $winnerHistory->draws + $oneMoreDraw;
        
        MatchHistory::where('id', $winnerHistory->id)
                    ->update([
                        'wins' => $totalWins,
                        'draws' => $totalDraws1,
                        'points' => $winnerNewTotalPoints,
                    ]);
        //case player had lost, then sum +1 to the total losses
        //case player had draw, then sum +1 to the total draws
        $totalLosses = $loserHistory->losses + $oneMoreLoss;
        $totalDraws2 = $winnerHistory->draws + $oneMoreDraw;
        MatchHistory::where('id', $loserHistory->id)
                    ->update([
                        'losses' => $totalLosses,
                        'draws' => $totalDraws2,
                        'points' => $loserNewTotalPoints,
                    ]);
        
        $matchDate = Carbon::parse($request->match_date)->format('Y-m-d');
        //saving data to new gameMatch row
        $gameMatch = new GameMatch();
        $gameMatch->rank_id = $rank_id->id;
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
        $gameMatch->validated_by = 1; //apenas teste
        $gameMatch->match_date = $matchDate;
        $gameMatch->submitted_date = $matchDate;
        //saving gameMatch first in order to get the id to pass in map FK game_match_id
        $gameMatch->save();

        $map1 = new Map();
        $map1->game_match_id = $gameMatch->id;
        $map1->map_name_id = $request->name_map1;
        $map1->screen = $request->img_1;
        $map1->score_winner = $request->player1_points_map1;
        $map1->score_loser = $request->player2_points_map1;
        $map1->save();
        

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

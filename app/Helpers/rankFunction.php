<?php

use App\Models\MatchHistory;
use App\Models\Rank;

//CALCULATE POINTS WON OR LOST
function elo($winnerTotalPoints, $loserTotalPoints, $gamesWinner, $gamesLoser, $draw){
    /*----------------------- ELO POINTS CALCULATIONS -----------------------------------*/
        
        //get deltaWinner and deltaLoser
        $deltaWinner = null;
        $deltaLoser = null;

        //adjusting K
        $k1 = null;
        $k2 = null;
    
        if($gamesWinner >= 50){
            $k1 = 24;
        }else if($gamesWinner >= 15){
            $k1 = 32;
        }else {
            $k1 = 40;
        }

        if($gamesLoser >= 50){
            $k2 = 24;
        }else if($gamesLoser >= 15){
            $k2 = 32;
        }else {
            $k2 = 40;
        }

        //getting deltas
        $delta = (1 / (1 + pow(10, abs($winnerTotalPoints - $loserTotalPoints) / 1000.0)));
        $delta_k1 = null;
        $delta_k2 = null;
        
        
        if($winnerTotalPoints < $loserTotalPoints){
            $delta = 1 - $delta;
        }
        if(!$draw){
            $delta_k1 = $k1 * $delta;
            $delta_k2 = -($k2 * $delta);
        }
        //draw
        else {
            if($winnerTotalPoints > $loserTotalPoints){
                $delta_k1 = -($k1 * $delta)/3;
                $delta_k2 = ($k2 * $delta)/3;
            }
            else if($winnerTotalPoints > $loserTotalPoints){
                $delta_k1 = ($k1 * $delta)/3;
                $delta_k2 = -($k2 * $delta)/3;
            } 
            else {
                $delta_k1 = 0;
                $delta_k2 = 0;
            }
        }

        $deltaWinner = round($delta_k1);
        $deltaLoser = round($delta_k2);
        //if the loser is going negative than limitate the losses until 0 points
        if(($deltaLoser + $loserTotalPoints) < 0){
            $deltaLoser = -$loserTotalPoints;
        }

        $winnerNewTotalPoints = $winnerTotalPoints + $deltaWinner;
        $loserNewTotalPoints = $loserTotalPoints + $deltaLoser;

        $deltaResults = [
            'winnerNewTotalPoints' => $winnerNewTotalPoints,
            'loserNewTotalPoints' => $loserNewTotalPoints,
            'deltaWinner' => $deltaWinner,
            'deltaLoser' => $deltaLoser
        ];
        return $deltaResults;
}

//get active rank id based on game-mode
function getCurrentRankId($gameMode){
    $rank_id = Rank::select('id')
                        ->where('is_active', 1)
                        ->where('game_mode', $gameMode)
                        ->first();
    return $rank_id->id;
}

//save images to public dir an returns it's new names to be stored on DB
function saveMapImages($request){
    //create new names to the imgs based on timestamps
    $newImageName1 = time() . '_' . 'img1' . '_' . $request->img_1->getClientOriginalName();
    $newImageName2 = time() . '_' . 'img2' . '_' . $request->img_2->getClientOriginalName();
    $newImageName3 = time() . '_' . 'img3' . '_' . $request->img_3->getClientOriginalName();
    //moving imgs to public directory
    $request->img_1->move(public_path('images'), $newImageName1);
    $request->img_2->move(public_path('images'), $newImageName2);
    $request->img_3->move(public_path('images'), $newImageName3);

    return [
        $newImageName1,
        $newImageName2,
        $newImageName3
    ];
}


function updateMatchHistory($winnerId, $loserId, $gameMode, $draw){

    //get total games and points from winner
    $winnerHistory = MatchHistory::where('competitor_id', $winnerId)
                                    ->where('game_mode', $gameMode)->first();
    $gamesWinner = $winnerHistory->wins + $winnerHistory->losses + $winnerHistory->draws;
    $winnerTotalPoints = $winnerHistory->points;
    //get total games and points from loser
    $loserHistory = MatchHistory::where('competitor_id', $loserId)
                                ->where('game_mode', $gameMode)->first();
    $gamesLoser = $loserHistory->wins + $loserHistory->losses + $loserHistory->draws;
    $loserTotalPoints = $loserHistory->points;

    //GET NEW TOTAL POINTS FROM ELO FUNCTION 
    $deltaResults = elo($winnerTotalPoints, $loserTotalPoints, $gamesWinner, $gamesLoser, $draw);
    $winnerNewTotalPoints = $deltaResults['winnerNewTotalPoints'];
    $loserNewTotalPoints = $deltaResults['loserNewTotalPoints'];
        
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
}
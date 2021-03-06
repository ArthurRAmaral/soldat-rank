<?php

use App\Models\Clan;
use App\Models\MatchHistory;
use App\Models\Rank;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Testing\MimeType;

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
    $rank_id = Rank::where('is_active', 1)
                        ->where('game_mode', $gameMode)
                        ->select('id')
                        ->first();
    return $rank_id->id;
}

//save images to public dir an returns it's new names to be stored on DB
function saveMapImages($request){
    
    $imageNames = [];

    //if the image exists then create a new name based on timestamps and move the image to public dir
    if(isset($request->img_1)){
        $newImageName1 = time() . '_' . 'img1' . '_' . $request->img_1->getClientOriginalName();
        $request->img_1->move(public_path('images'), $newImageName1);
        array_push($imageNames, $newImageName1);
    }else{
        array_push($imageNames, null);
    }
    if(isset($request->img_2)){
        $newImageName2 = time() . '_' . 'img2' . '_' . $request->img_2->getClientOriginalName();
        $request->img_2->move(public_path('images'), $newImageName2);
        array_push($imageNames, $newImageName2);
    }else{
        array_push($imageNames, null);
    }
    if(isset($request->img_3)){
        $newImageName3 = time() . '_' . 'img3' . '_' . $request->img_3->getClientOriginalName();
        $request->img_3->move(public_path('images'), $newImageName3);
        array_push($imageNames, $newImageName3);
    }else {
        array_push($imageNames, null);
    }
    
    return $imageNames;
}


function updateMatchHistory($winnerId, $loserId, $gameMode, $draw){

    $activeRank = getCurrentRankId($gameMode);

    //get total games and points from winner
    $winnerHistory = MatchHistory::where('competitor_id', $winnerId)
                                    ->where('game_mode', $gameMode)
                                    ->where('rank_id', $activeRank)
                                    ->first();
    $gamesWinner = $winnerHistory->wins + $winnerHistory->losses + $winnerHistory->draws;
    $winnerTotalPoints = $winnerHistory->points;
    //get total games and points from loser
    $loserHistory = MatchHistory::where('competitor_id', $loserId)
                                ->where('game_mode', $gameMode)
                                ->where('rank_id', $activeRank)
                                ->first();
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

function latinDateFormat($date){
    $date = new Carbon($date);
    $day = $date->day;
    $month = $date->month;
    if($day < 10){
        $day = '0' . $day;
    }
    if($month < 10){
        $month = '0' . $month;
    }

    $newDateFormat = $day . '/' . $month . '/' . $date->year;

    return $newDateFormat;
}

//get the diffenrence in days between 2 dates
function daysDiff($date1, $date2){
    return Carbon::parse($date1)->diffInDays($date2);
}

//return what's the percentage of a portion related to the total
function percentFromTotal($portion, $total){
    if($portion == 0){
        return 0;
    }
    if($total == 0){
        return 0;
    }
    $percent = $total / 100;
    $percent = $portion / $percent;
    
    return round($percent);
}


function createMatchHistories($gameMode, $rankId){
    if($gameMode == "DM"){
        $users = User::all();
        foreach($users as $user){
            MatchHistory::create([
                'game_mode' => 'DM',
                'wins' => 0,
                'losses' => 0,
                'draws' => 0,
                'points' => 0,
                'competitor_id' => $user->id,
                'rank_id' => $rankId
            ]);
        }
    }
    elseif($gameMode == "TM"){
        $clans = Clan::all();
        foreach($clans as $clan){
            MatchHistory::create([
                'game_mode' => 'TM',
                'wins' => 0,
                'losses' => 0,
                'draws' => 0,
                'points' => 0,
                'competitor_id' => $clan->id,
                'rank_id' => $rankId
            ]);
        }
    }
}

function getImageExtension($img){
    $mime = MimeType::from($img);
    $mime = explode('/', $mime, 2);
    dd($mime);
    if($mime[0] === 'image'){
        return $mime[1];
    }else {
        return null;
    }
}
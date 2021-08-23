<?php

namespace App\Http\Controllers;

use App\Models\GameMatch;
use App\Models\MatchHistory;
use App\Models\Rank;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //getting the active ranks
        $clansActiveRank = Rank::where('game_mode', 'TM')->where('is_active', 1)->first();
        $playersActiveRank = Rank::where('game_mode', 'DM')->where('is_active', 1)->first();

        //formatting date in readable string
        $clanRankStart = latinDateFormat($clansActiveRank->start);
        $clanRankEnd = latinDateFormat($clansActiveRank->end);
        $playerRankStart = latinDateFormat($playersActiveRank->start);
        $playerRankEnd = latinDateFormat($playersActiveRank->end);

        //how long it will take to finish the rank from now
        $clanDaysLeft = daysDiff($clansActiveRank->end, Carbon::now());
        $playerDaysLeft = daysDiff($playersActiveRank->end, Carbon::now());

        //how long the ranked is going to take from beginner to end
        $clanTotalDays = daysDiff($clansActiveRank->start, $clansActiveRank->end);
        $playerTotalDays = daysDiff($playersActiveRank->start, $playersActiveRank->end);

        //rank progress in percentage
        $clanRankPercent = percentFromTotal($clanTotalDays - $clanDaysLeft, $clanTotalDays);
        $playerRankPercent = percentFromTotal($playerTotalDays - $playerDaysLeft, $playerTotalDays);

        //get all the validated matches published
        $playerGames = GameMatch::where('game_mode', 'DM')
                                    ->where('rank_id', $playersActiveRank->id)
                                    ->where('is_validated', 1)
                                    ->get();
        $clanGames= GameMatch::where('game_mode', 'TM')
                                    ->where('rank_id', $clansActiveRank->id)
                                    ->where('is_validated', 1)
                                    ->get();

        $clanGames = count($clanGames);
        $playerGames = count($playerGames);

        $activeClans = MatchHistory::where('rank_id', $clansActiveRank->id)
                                    ->where(function($query){
                                        $query->where('wins', '>', 0)
                                                ->orWhere('losses', '>', 0)
                                                ->orWhere('draws', '>', 0);
                                    })->get();

        $activePlayers = MatchHistory::where('rank_id', $playersActiveRank->id)
                                    ->where(function($query){
                                        $query->where('wins', '>', 0)
                                                ->orWhere('losses', '>', 0)
                                                ->orWhere('draws', '>', 0);
                                    })->get();
        $activeClans = count($activeClans);
        $activePlayers = count($activePlayers);

        return view('pages.rank.season.index', [
            'clansActiveRank' => $clansActiveRank,
            'playersActiveRank' => $playersActiveRank,
            'activeClans' => $activeClans,
            'activePlayers' => $activePlayers,
            'clanGames' => $clanGames,
            'playerGames' => $playerGames,
            'clanRankStart' => $clanRankStart,
            'clanRankEnd' => $clanRankEnd,
            'playerRankStart' => $playerRankStart,
            'playerRankEnd' => $playerRankEnd,
            'playerDaysLeft' => $playerDaysLeft,
            'clanDaysLeft' => $clanDaysLeft,
            'clanTotalDays' => $clanTotalDays,
            'playerTotalDays' => $playerTotalDays,
            'playerRankPercent' => $playerRankPercent,
            'clanRankPercent' => $clanRankPercent
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $dateNow = Carbon::now('America/Sao_Paulo')->format('d/m/Y');
        $minDate = Carbon::now('America/Sao_Paulo')->format('Y-m-d');
        $gameMode = Rank::find($request->endingRank);
        $gameMode = $gameMode->game_mode;

        return view('pages.rank.season.create', [
            'endingRank' => $request->endingRank,
            'dateNow' => $dateNow,
            'gameMode' => $gameMode,
            'minDate' => $minDate
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
            'rankTitle' => 'required|string|max:255',
            'endDate' => 'required|date_format:d/m/Y',
            'endingRank' => 'integer|required',
        ]);
        $endingRank = Rank::find($request->endingRank);
        $endDate = Carbon::createFromFormat('d/m/Y', $request->endDate)->format('Y-m-d');
        $now = Carbon::now('America/Sao_Paulo')->format('Y-m-d');

        $rank = new Rank;
        $rank->title = $request->rankTitle;
        $rank->end = $endDate;
        $rank->start = $now;
        $rank->is_active = 1;
        $rank->game_mode = $endingRank->game_mode;
        $rank->save();

        $endingRank->is_active = 0;
        $endingRank->save();

        createMatchHistories($endingRank->game_mode, $rank->id);

        return redirect()->route('seasons');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rank  $rank
     * @return \Illuminate\Http\Response
     */
    public function show(Rank $rank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rank  $rank
     * @return \Illuminate\Http\Response
     */
    public function edit($gameMode)
    {
        $activeRank = Rank::where('game_mode', $gameMode)->where('is_active', 1)->first();

        $rankStart = latinDateFormat($activeRank->start);
        $rankEnd = latinDateFormat($activeRank->end);


        //how long it will take to finish the rank from now
        $daysLeft = daysDiff($activeRank->end, Carbon::now());

        //how long the ranked is going to take from beginner to end
        $totalDays = daysDiff($activeRank->start, $activeRank->end);

        //rank progress in percentage
        $rankPercent = percentFromTotal($totalDays - $daysLeft, $totalDays);

        $dateNow = Carbon::now('America/Sao_Paulo')->format('Y-m-d');

        return view('pages.rank.season.edit', [
            'rankPercent' => $rankPercent,
            'rankStart' => $rankStart,
            'rankEnd' => $rankEnd,
            'activeRank' => $activeRank,
            'daysLeft' => $daysLeft,
            'dateNow' => $dateNow
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rank  $rank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $endDate = Carbon::createFromFormat('d/m/Y', $request->endDate);
        $endDate = $endDate->toDateString();

        $rank = Rank::findOrFail($request->rankId);
        $rank->end = $endDate;
        $rank->title = $request->rankTitle;
        $rank->save();

        return redirect()->route('seasons');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rank  $rank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        dd($request);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use App\Models\MatchHistory;
use App\Models\Rank;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clans = Clan::all();
        $leaders = array();
        foreach($clans as $clan){
            array_push($leaders, User::find($clan->leader_id));
        }
        return view('pages.clan.index',[
            'clans' => $clans,
            'leaders' => $leaders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.clan.create');
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
            'name' => 'required|unique:clans|max:255',
            'tag' => 'required|unique:clans,tag|max:255'
        ]);

        $clan = new Clan;
        $clan->name = $request->name;
        $clan->tag = $request->tag;
        $clan->leader_id = Auth::id();
        $clan->save();

        //CREATE NEW CLAN HISTORY
        $rank_id = Rank::select('id')
        ->where('is_active', 1)
        ->where('game_mode', 'TM')
        ->first();

        //use new clan id to create a new history instance for the clan
        MatchHistory::create([
        'game_mode' => 'TM',
        'wins' => 0,
        'losses' => 0,
        'draws' => 0,
        'points' => 0,
        'competitor_id' => $clan->id,
        'rank_id' => $rank_id->id
        ]);
        
        DB::table('users')->where('id', Auth::id())->update(['clan_id' => $clan->id]);

        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clan  $clan
     * @return \Illuminate\Http\Response
     */
    public function show(Clan $clan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clan  $clan
     * @return \Illuminate\Http\Response
     */
    public function edit(Clan $clan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clan  $clan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clan $clan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clan  $clan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clan $clan)
    {
        //
    }

}

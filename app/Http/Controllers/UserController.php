<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use App\Models\MatchHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $players = User::leftJoin('clans', 'users.clan_id', '=', 'clans.id')
                        ->select('users.id as userId', 'clans.id as clanId',
                        'users.nickname', 'clans.tag as clanTag', 
                        'users.logo as userLogo')->get();

        return view('pages.player.index', [
            'players' => $players,
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
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rankId = getCurrentRankId('DM');
        $player = User::findOrFail($id);
        $history = MatchHistory::where('game_mode', 'DM')
                                ->where('competitor_id', $player->id)
                                ->where('rank_id', $rankId)
                                ->first();
        $clan = null;
        if($player->clan_id){
            $clan = Clan::find($player->clan_id);
        }

        if($id == Auth::id()){
            $auth = true;
        }else{
            $auth = false;
        }
        
        return view('pages.player.show', [
            'player' => $player,
            'clan' => $clan,
            'history' => $history,
            'auth' => $auth
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function me()
    {
        $rankId = getCurrentRankId('DM');
        $player = Auth::user();
        $history = MatchHistory::where('game_mode', 'DM')
                                ->where('competitor_id', $player->id)
                                ->where('rank_id', $rankId)
                                ->first();
        $clan = null;
        if($player->clan_id){
            $clan = Clan::find($player->clan_id);
        }

        return view('pages.player.show', [
            'player' => $player,
            'clan' => $clan,
            'history' => $history,
            'auth' => true
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $player = User::findOrFail($id);

        return view('pages.player.edit', [
            'player' => $player,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'newLogo' => 'mimes:jpg,png,jpeg,webp|max:6048',
        ]);
        $user = User::findOrFail(Auth::id());

        if(!$request->newLogo){
            return redirect()->route('player-profile', ['id' => $user->id]);
        }
        else{
            //make logo name based on username
            $ext = $request->file('newLogo')->extension();
            $logoName = $user->username . '_' . 'logo.' . $ext;
            if(file_exists(public_path('players-logos/' . $logoName))){
                unlink(public_path('players-logos/' . $logoName));
            }

            $request->newLogo->move(public_path('players-logos'), $logoName);
            $user->logo = $logoName;
            $user->save();    

            return redirect()->route('player-profile', ['id' => $user->id]);
        }
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

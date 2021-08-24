<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use App\Models\JoinRequest;
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

    //actions to normal members
    public function memberAction(Request $request){
        if($request->promote){
            $user = User::find($request->promote);
            $user->is_clan_manager = 1;
            $user->save();
        }
        elseif($request->kick_out){
            $user = User::find($request->kick_out);
            $user->clan_id = null;
            $user->is_clan_manager = 0;
            $user->save();
        }
        return redirect()->route('clans.edit', ['id' => $request->clanId]);
    }

    //actions to managers
    public function managerAction(Request $request){
        if($request->demote){
            $user = User::find($request->demote);
            $user->is_clan_manager = 0;
            $user->save();
        }
        elseif($request->kick_out){
            $user = User::find($request->kick_out);
            $user->clan_id = null;
            $user->is_clan_manager = 0;
            $user->save();
        }
        return redirect()->route('clans.edit', ['id' => $request->clanId]);
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
        

        $user = User::find(Auth::user()->id);
        $user->clan_id = $clan->id;
        $user->is_clan_manager = 1;
        $user->save();

        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clan  $clan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rankId = getCurrentRankId('TM');
        $clan = Clan::findOrFail($id);
        $leader = User::find($clan->leader_id);
        $history = MatchHistory::where('game_mode', 'TM')
                                ->where('competitor_id', $clan->id)
                                ->where('rank_id', $rankId)
                                ->first();
        $members = User::where('clan_id', $id)
                        ->where('users.id', '<>', $leader->id)
                        ->get();
        $currentPlayer = Auth::user();

        //clan manager or leader permission
        $clanManager = 0;
        if($currentPlayer->clan_id === $clan->id && $currentPlayer->is_clan_manager === 1){
            if($currentPlayer->id === $clan->leader_id){
                $clanManager = 2;
            }else{
                $clanManager = 1;
            }
        }

        return view('pages.clan.show', [
            'clan' => $clan,
            'history' => $history,
            'leader' => $leader,
            'members' => $members,
            'currentPlayer' => $currentPlayer,
            'clanManager' => $clanManager
        ]);
    }

     /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clan  $clan
     * @return \Illuminate\Http\Response
     */
    //show currently authenticated user clan
    public function mine()
    {
        $clan = Clan::findOrFail(Auth::user()->clan_id);
        $leader = User::find($clan->leader_id);
        $rankId = getCurrentRankId('TM');
        $history = MatchHistory::where('game_mode', 'TM')
                                ->where('competitor_id', $clan->id)
                                ->where('rank_id', $rankId)
                                ->first();

        $members = User::where('clan_id', $clan->id)->get();
        $currentPlayer = Auth::user();

        $clanManager = 0;
        if($currentPlayer->clan_id === $clan->id && $currentPlayer->is_clan_manager === 1){
            if($currentPlayer->id === $clan->leader_id){
                $clanManager = 2;
            }else{
                $clanManager = 1;
            }
        }

        return view('pages.clan.show', [
            'clan' => $clan,
            'history' => $history,
            'leader' => $leader,
            'members' => $members,
            'currentPlayer' => $currentPlayer,
            'clanManager' => $clanManager
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clan  $clan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clan = Clan::findOrFail($id);
        $leader = User::find($clan->leader_id);
        $members = User::where('clan_id', $id)
                        ->where('is_clan_manager', '<>', 1)
                        ->get();
        $managers = User::where('clan_id', $id)
                        ->where('users.id', '<>', $clan->leader_id)
                        ->where('is_clan_manager', 1)
                        ->get();
        $currentPlayer = Auth::user();
        $isLeader = null;
        if($clan->leader_id === Auth::user()->id){
            $isLeader = true;
        }else{
            $isLeader = false;
        }
        //get all requests to join the clan
        $joinRequests = JoinRequest::where('join_requests.clan_id', $id)
                                    ->join('users', 'join_requests.user_id', '=', 'users.id')
                                    ->select('users.nickname', 'users.name', 'users.id', 'join_requests.id as requestId')
                                    ->get();


        //clan manager or leader permission
        $clanManager = 0;
        if($currentPlayer->clan_id === $clan->id && $currentPlayer->is_clan_manager === 1){
            if($currentPlayer->id === $clan->leader_id){
                $clanManager = 2;
            }else{
                $clanManager = 1;
            }
        }

        return view('pages.clan.edit', [
            'clan' => $clan,
            'leader' => $leader,
            'members' => $members,
            'managers' => $managers,
            'currentPlayer' => $currentPlayer,
            'clanManager' => $clanManager,
             'joinRequests' => $joinRequests,
             'isLeader' => $isLeader,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clan  $clan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $userId = null;
        if($request->accept){
            //add clan to user
            $newMember = User::findOrFail($request->accept);
            $newMember->clan_id = $request->clanId;
            $newMember->save();
            $userId = $request->accept;
            JoinRequest::where('join_requests.user_id', $request->accept)->delete();
        }else{
            $joinRequest = JoinRequest::where('join_requests.clan_id', $request->clanId)
                                    ->where('join_requests.user_id', $request->refuse)
                                    ->first();
        
        $joinRequest->delete();
        }

        return redirect()->route('clans.edit', ['id' => $request->clanId]);
        
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

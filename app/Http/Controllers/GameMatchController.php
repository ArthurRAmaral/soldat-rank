<?php

namespace App\Http\Controllers;

use App\Models\Championship;
use App\Models\Clan;
use App\Models\GameMatch;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameMatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
       
        $matches = DB::table('game_matches')->leftJoin('championships', 'game_matches.championship_id', '=', 'championships.id')
        ->leftJoin('users as player_winner', 'game_matches.winner', '=', 'player_winner.id')
        ->leftJoin('users as player_loser', 'game_matches.loser', '=', 'player_loser.id')
        ->leftJoin('clans as clan_winner', 'game_matches.winner', '=', 'clan_winner.id')
        ->leftJoin('clans as clan_loser', 'game_matches.loser', '=', 'clan_loser.id')
        ->select('player_winner.name as winner_name', 'player_loser.name as loser_name', 
        'clan_winner.name as clan_winner_name', 'clan_loser.name as clan_loser_name',
        'championships.title as champ_title','championships.game_mode', 'game_matches.*')
        ->get();
        
        //fazendo o decode de json para object e armazenando em $matches
        foreach($matches as $match){
            if($match->game_mode == 'cf'){
                $match->winner_name = $match->clan_winner_name;
                $match->loser_name = $match->clan_loser_name;
            }
            $match->img = json_decode($match->img);
        }
        return view("pages.game_match.index", [
            'matches' => $matches
        ]);
    }

    public function chooseGameModePage(){
        $championships = Championship::all();

        return view('pages.game_match.choose_mode', [
            'championships' => $championships,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        $championship = Championship::find($request->championship_id);

        $draw = null;
        $label1 = null;
        $label2 = null;
        if($request->draw){
            $draw = true;
            $label1 = "Adversário 1";
            $label2 = "Adversário 2";
        }else{
            $draw = false;
            $label1 = "Vencedor";
            $label2 = "Perdedor";
        }

        //if cf, then show only clans in select options and pass the apropriate labels
        if($championship->game_mode === 'cf'){
            $clans = Clan::all();
            return view("pages.game_match.create", [
                'competitors' => $clans,
                'championship' => $championship,
                'draw' => $draw,
                'label1' => $label1,
                'label2' => $label2
            ]);
        //if x1, then show only players in select options and pass the apropriate labels
        }else { 
            $players = User::all();
            return view("pages.game_match.create", [
                'competitors' => $players,
                'championship' => $championship,
                'draw' => $draw,
                'label1' => $label1,
                'label2' => $label2
            ]);
        }
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
            'championship_id' => 'required|integer',
            'competitor1' => 'required|string|max:255',
            'competitor2' => 'required|string|max:255',
            'img_1' => 'required|mimes:jpg,png,jpeg|max:5048',
            'img_2' => 'required|mimes:jpg,png,jpeg|max:5048',
            'img_3' => 'required|mimes:jpg,png,jpeg|max:5048',
            'match_date' => 'required|date_format:d-m-Y'
        ]);
        
       //criando nomes unicos para as imagens se baseando no timestamp da requisição
        $newImageName1 = time() . '_' . 'img1' . '_' . $request->img_1->getClientOriginalName();
        $newImageName2 = time() . '_' . 'img2' . '_' . $request->img_2->getClientOriginalName();
        $newImageName3 = time() . '_' . 'img3' . '_' . $request->img_3->getClientOriginalName();
        //movendo para pasta images no diretorio publico
        $request->img_1->move(public_path('images'), $newImageName1);
        $request->img_2->move(public_path('images'), $newImageName2);
        $request->img_3->move(public_path('images'), $newImageName3);

        //adicionando o nome das imagens no mesmo campo do BD como json
        $maps = json_encode([$newImageName1, $newImageName2, $newImageName3]);
        $competitors = json_encode([$request->competitor1, $request->competitor2]);

       //formatando a data no formato aceito pelo DataBase
        $match_date = Carbon::parse($request->match_date)->format('Y-m-d');

        //passando os dados que serão armazenados
        $game_match = new GameMatch();
        $game_match->championship_id = $request->championship_id;
        $game_match->competitors = $competitors;
        $game_match->img = $maps;
        $game_match->match_date = $match_date;

        if($request->draw){
            $game_match->draw = true;
        }else{
            $game_match->draw = false;
            $game_match->winner = $request->competitor1;
            $game_match->loser = $request->competitor2;
        }
        
        //armazenando dados
        $game_match->save();
        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GameMatch  $gameMatch
     * @return \Illuminate\Http\Response
     */
    public function show(GameMatch $gameMatch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GameMatch  $gameMatch
     * @return \Illuminate\Http\Response
     */
    public function edit(GameMatch $gameMatch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GameMatch  $gameMatch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GameMatch $gameMatch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GameMatch  $gameMatch
     * @return \Illuminate\Http\Response
     */
    public function destroy(GameMatch $gameMatch)
    {
        //
    }
}

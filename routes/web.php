<?php

use App\Http\Controllers\ChampionshipController;
use App\Http\Controllers\ClanController;
use App\Http\Controllers\GameMatchController;
use App\Http\Controllers\GameMatchDmController;
use App\Http\Controllers\GameMatchTmController;
use App\Http\Controllers\DmValidateController;
use App\Http\Controllers\TmValidateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JoinRequestController;
use App\Http\Controllers\MapNameController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();
/*
Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');
*/

Route::group(['middleware' => 'auth'], function(){

    Route::get('/home', function() {
        return view('home');
    })->name('home');
    //start clans
    Route::get('/clans/create', [ClanController::class, 'create'])->name('clans/create')->middleware('not.clan.member');

    Route::post('/clans', [ClanController::class, 'store'])->middleware('not.clan.member');

    Route::get('/clans', [ClanController::class, 'index'])->name('clans');
    //end clans

    //start championships
    Route::get('/championships', [ChampionshipController::class, 'index'])->name('championships');

    Route::get('/championships/create', [ChampionshipController::class, 'create'])->name('championships/create');

    Route::post('/championships', [ChampionshipController::class, 'store']);
    //end championships
    
    //dm
    Route::get('/game_match/dm/create', [GameMatchDmController::class, 'create'])->name('game_match/dm/create');
    Route::get('/game_match/dm', [GameMatchDmController::class, 'index'])->name('game_match/dm');
    Route::get('/game_match/dm/rank', [GameMatchDmController::class, 'rank'])->name('game_match/dm/rank');
    Route::post('/game_match/dm', [GameMatchDmController::class, 'store']);
   
    //tm
    Route::get('/game_match/tm/create', [GameMatchTmController::class, 'create'])->name('game_match/tm/create')->middleware('clan.member');
    Route::get('/game_match/tm', [GameMatchTmController::class, 'index'])->name('game_match/tm');
    Route::get('/game_match/tm/rank', [GameMatchTmController::class, 'rank'])->name('game_match/tm/rank');
    Route::post('/game_match/tm', [GameMatchTmController::class, 'store'])->middleware('clan.member');
    //player profile
    Route::get('/players/{id}', [UserController::class, 'show'])->name('player-profile');
    Route::get('/my-profile', [UserController::class, 'me'])->name('my-profile');
    //clan profile
    Route::get('/clans/{id}', [ClanController::class, 'show'])->name('clan-profile');
    Route::get('/my-clan-profile', [ClanController::class, 'mine'])->name('my-clan-profile');
    Route::get('/clans/{id}/edit', [ClanController::class, 'edit'])->name('clans.edit')->middleware('clan.manager');
    Route::post('/clan/update', [ClanController::class, 'update'])->name('clan.put')->middleware('clan.manager');
    Route::post('/clan/member/action', [ClanController::class, 'memberAction'])->name('member.action')->middleware('clan.manager');
    Route::post('/clan/manager/action', [ClanController::class, 'managerAction'])->name('manager.action')->middleware('clan.manager');
    //join request
    Route::get('/join-request', [JoinRequestController::class, 'index'])->name('join-request');
    Route::post('/join-request', [JoinRequestController::class, 'store']);

    //maps
    Route::get('/mapnames', [MapNameController::class, 'index'])->name('mapnames')->middleware('admin');
    Route::post('/mapnames', [MapNameController::class, 'store'])->middleware('admin');
    Route::post('/mapnames/destroy', [MapNameController::class, 'destroy'])->name('mapnames.destroy')->middleware('admin');

    Route::group(['middleware' => 'validator'], function(){
        //validating dm
        Route::get('/dm_validate', [DmValidateController::class, 'index'])->name('dm_validate');
        Route::post('/dm_validate', [DmValidateController::class, 'store']);

        //validating tm
        Route::get('/tm_validate', [TmValidateController::class, 'index'])->name('tm_validate');
        Route::post('/tm_validate', [TmValidateController::class, 'store']);
    });
    
});

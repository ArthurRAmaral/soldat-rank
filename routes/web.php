<?php

use App\Http\Controllers\ClanController;
use App\Http\Controllers\GameMatchDmController;
use App\Http\Controllers\GameMatchTmController;
use App\Http\Controllers\DmValidateController;
use App\Http\Controllers\TmValidateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JoinRequestController;
use App\Http\Controllers\MapNameController;
use App\Http\Controllers\RankController;
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

Route::group(['middleware' => 'auth'], function(){

    Route::get('/home', function() {
        return view('home');
    })->name('home');
    //start clans
    Route::get('/clans/create', [ClanController::class, 'create'])->name('clans/create')->middleware('not.clan.member');

    Route::post('/clans', [ClanController::class, 'store'])->middleware('not.clan.member');

    Route::get('/clans', [ClanController::class, 'index'])->name('clans');
    //end clans

    
    //dm
    Route::get('/test', [GameMatchTmController::class, 'test'])->name('test');
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
    Route::get('/players', [UserController::class, 'index'])->name('players');
    Route::get('/players/{id}', [UserController::class, 'show'])->name('player-profile');
    Route::get('/my-profile', [UserController::class, 'me'])->name('my-profile');
    Route::get('/player/{id}/edit', [UserController::class, 'edit'])->name('player.edit')->middleware('auth.profile');
    Route::post('/player/update', [UserController::class, 'update'])->name('player.update')->middleware('auth');

    //clan profile
    Route::get('/clans/{id}', [ClanController::class, 'show'])->name('clan-profile');
    Route::get('/my-clan-profile', [ClanController::class, 'mine'])->name('my-clan-profile');
    Route::get('/clans/{id}/edit', [ClanController::class, 'edit'])->name('clans.edit')->middleware(['clan.manager', 'clan.profile']);
    Route::post('/clan/update', [ClanController::class, 'update'])->name('clan.put')->middleware(['clan.manager', 'clan.update']);
    Route::post('/clan/update/logo', [ClanController::class, 'updateLogo'])->name('clan.logo')->middleware(['clan.manager', 'clan.update']);
    Route::post('/clan/member/action', [ClanController::class, 'memberAction'])->name('member.action')->middleware(['clan.manager', 'clan.update']);
    Route::post('/clan/manager/action', [ClanController::class, 'managerAction'])->name('manager.action')->middleware(['clan.manager', 'clan.update']);

    //join request
    Route::post('/join-request', [JoinRequestController::class, 'store'])->name('join-request')->middleware('join.request');

    //maps
    Route::get('/mapnames', [MapNameController::class, 'index'])->name('mapnames')->middleware('admin');
    Route::post('/mapnames', [MapNameController::class, 'store'])->middleware('admin');
    Route::post('/mapnames/destroy', [MapNameController::class, 'destroy'])->name('mapnames.destroy')->middleware('admin');

    //season / rank
    Route::get('/seasons', [RankController::class, 'index'])->name('seasons');
    Route::post('/seasons', [RankController::class, 'store'])->middleware('admin');
    Route::get('/seasons/{gameMode}/edit', [RankController::class, 'edit'])->name('seasons.edit')->middleware('admin');
    Route::post('/seasons/update', [RankController::class, 'update'])->name('seasons.update')->middleware('admin');
    Route::get('/seasons/create', [RankController::class, 'create'])->name('seasons.create')->middleware('admin');

    //access management
    Route::get('/manager/players', [UserController::class, 'access'])->name('players.manager')->middleware(['admin']);
    Route::post('/promote-admin', [UserController::class, 'promoteAdmin'])->name('promote.admin')->middleware(['admin']);
    Route::post('/demote-admin', [UserController::class, 'demoteAdmin'])->name('demote.admin'); //superuser
    Route::post('/promote-superuser', [UserController::class, 'promoteSuperuser'])->name('promote.superuser'); //superuser
    Route::post('/demote-superuser', [UserController::class, 'demoteSuperuser'])->name('demote.superuser'); //superuser
    Route::post('/player/destroy', [UserController::class, 'destroy'])->name('player.destroy')->middleware('admin');
    Route::post('/promote-validator', [UserController::class, 'promoteValidator'])->name('promote.validator')->middleware('admin');
    Route::post('/demote-validator', [UserController::class, 'demoteValidator'])->name('demote.validator')->middleware('admin');

    Route::group(['middleware' => 'validator'], function(){
        //validating dm
        Route::get('/dm_validate', [DmValidateController::class, 'index'])->name('dm_validate');
        Route::post('/dm_validate', [DmValidateController::class, 'store']);

        //validating tm
        Route::get('/tm_validate', [TmValidateController::class, 'index'])->name('tm_validate');
        Route::post('/tm_validate', [TmValidateController::class, 'store']);
    });
    
});
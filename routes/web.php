<?php

use App\Http\Controllers\ChampionshipController;
use App\Http\Controllers\ClanController;
use App\Http\Controllers\GameMatchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Match_;

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

    Route::get('/clans/create', [ClanController::class, 'create'])->name('clans/create');

    Route::post('/clans', [ClanController::class, 'store']);

    Route::get('/clans', [ClanController::class, 'index'])->name('clans');

    Route::get('/championships', [ChampionshipController::class, 'index'])->name('championships');

    Route::get('/championships/create', [ChampionshipController::class, 'create'])->name('championships/create');

    Route::post('/championships', [ChampionshipController::class, 'store']);

    Route::get('/game_matches', [GameMatchController::class, 'index'])->name('game_matches');

    Route::get('/game_matches/create', [GameMatchController::class, 'create'])->name('game_matches/create');

    Route::post('/game_matches', [GameMatchController::class, 'store']);

    Route::get('/choose_game_mode', [GameMatchController::class, 'chooseGameModePage'])->name('/choose_game_mode');
});

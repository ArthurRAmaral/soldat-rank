@extends('adminlte::page')

@section('title', 'Perfil')

@section('content_header')
    <h1>Temporadas Ativas</h1>
@stop


@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col p-4">
                <div class="row">
                    <div class="d-flex flex-column">
                        <h2 class="align-self-center">Temporada de Clãs</h2>
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-column">
                                <p class="fs-5 text align-self-center">Inicio</p>
                                <p>{{$clanRankStart}}</p>
                            </div>
                            <div class="d-flex flex-column">
                                <p class="fs-5 text align-self-center">Fim</p>
                                <p>{{$clanRankEnd}}</p>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{$clanRankPercent}}%;" aria-valuenow="{{$clanRankPercent}}" aria-valuemin="0" aria-valuemax="100">{{$clanRankPercent}}%</div>
                        </div>
                        <p class="align-self-center fs-6">Faltam <span class="fs-5 text text-info">{{$clanDaysLeft}}</span> dias</p>
                        <div>

                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="d-flex flex-column align-items-center">
                        <div class="d-flex flex-column align-items-center">
                            <p class="fs-5 text">Total de partidas</p>
                            <p class="fs-1">{{$clanGames}}</p>
                        </div>

                        <div class="d-flex flex-column align-items-center">
                            <p class="fs-5 text">Clãs ativos</p>
                            <p class="fs-1">{{$activeClans}}</p>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="col p-4">
                <div class="row">
                    <div class="d-flex flex-column">
                        <h2 class="align-self-center">Temporada de Jogadores</h2>
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-column">
                                <p class="fs-5 text align-self-center">Inicio</p>
                                <p>{{$playerRankStart}}</p>
                            </div>
                            <div class="d-flex flex-column">
                                <p class="fs-5 text align-self-center">Fim</p>
                                <p>{{$playerRankEnd}}</p>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{$playerRankPercent}}%;" aria-valuenow="{{$playerRankPercent}}" aria-valuemin="0" aria-valuemax="100">{{$clanRankPercent}}%</div>
                        </div>
                        <p class="align-self-center fs-6 text">faltam <span class="fs-5 text text-info">{{$playerDaysLeft}}</span> dias</p>
                        <div>

                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="d-flex flex-column align-items-center">
                        <div class="d-flex flex-column align-items-center">
                            <p class="fs-5 text">Total de partidas</p>
                            <p class="fs-1">{{$playerGames}}</p>
                        </div>

                        <div class="d-flex flex-column align-items-center">
                            <p class="fs-5 text">Jogadores ativos</p>
                            <p class="fs-1">{{$activePlayers}}</p>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@stop
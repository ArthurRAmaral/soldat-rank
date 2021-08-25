@extends('adminlte::page')

@section('title', 'Perfil')

@section('content_header')
<div class="d-flex justify-content-between">
    <div>
        <img class="rounded-circle p-1" height="60" width="60" src="/players-logos/{{$player->logo}}" alt="logo">
        <span class="fs-2 fw-bold align-middle">{!! $player->nickname !!}</span>
    </div>

    @if ($auth)
        <form action="{{route('player.edit', ['id' => $player->id])}}" method="get">
            <button type="submit" class="btn btn-outline-secondary me-3">Editar</button>
        </form>
    @endif
</div>
    
@stop


@section('content')

  <div class="container">
    <div class="row">

        <div class="col">
            <label for="test">Player</label>
            <ul name="test" class="list-group list-group-flush">
                <li class="list-group-item"><mark>Nome:</mark> {{$player->name}}</li>
                <li class="list-group-item"><mark>Nick:</mark> {{$player->nickname}}</li>
                @if (isset($clan))
                <li class="list-group-item"><mark>Clan:</mark> <a class="text-dark" href="/clans/{{$clan->id}}">{{$clan->name}}</a></li>
                @else
                <li class="list-group-item"><mark>Clan:</mark> nenhum</li>
                @endif
                <li class="list-group-item"> -----</li>
            </ul>
        </div>

        <div class="col">
            <label for="test">Death Match</label>
            <ul name="test" class="list-group list-group-flush">
                <li class="list-group-item"><mark>Jogos:</mark> {{$history->wins + $history->losses + $history->draws}}</li>
                <li class="list-group-item"><mark>Vitórias:</mark> {{$history->wins}}</li>
                <li class="list-group-item"><mark>Derrotas:</mark> {{$history->losses}}</li>
                <li class="list-group-item"><mark>Empates:</mark> {{$history->draws}}</li>
            </ul>
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
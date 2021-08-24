@extends('adminlte::page')

@section('title', 'Perfil')

{{-- HEADER --}}
@section('content_header')
<div class="d-flex justify-content-between">
    <div class="p-2 bd-highlight">
        <div>
            <img class="rounded-circle p-1" height="60" width="60" src="/clans-logos/{{$clan->logo}}" alt="logo">
            <span class="fs-2 fw-bold align-middle">{!! $clan->name !!}</span>
          </div>
    </div>
    @if (!$currentPlayer->clan_id)
        <div class="p-2 bd-highlight">
            <form action="{{route('join-request')}}" method="post">
                @csrf
                <input type="hidden" name="joinClanId" value="{{$clan->id}}">
                <button type="submit" class="btn btn-secondary">Pedir para entrar no clã</button>
            </form>
        </div>
    @endif
    
    @if ($clanManager)
        <form action="{{route('clans.edit', ['id' => $clan->id])}}" method="get">
            @csrf
            <input type="hidden" name="joinClanId" value="{{$clan->id}}">
            <button type="submit" class="btn btn-secondary">Gerenciar Clã</button>
        </form>
    @endif
    
</div>
@stop

@php
    $index = 1;
@endphp

@section('content')

  <div class="container">
    <div class="row">
        {{-- DETALHES --}}
        <div class="col">
            <label for="test">Detalhes</label>
            <ul name="test" class="list-group list-group-flush">
                <li class="list-group-item">
                    <mark>Nome:</mark>
                    <a href="/clans/{{$clan->id}}" class="link-dark">{{$clan->name}}</a>
                </li>
                <li class="list-group-item"><mark>Tag:</mark> {{$clan->tag}}</li>
                <li class="list-group-item">
                    <mark>Líder:</mark> 
                    <a href="/players/{{$leader->id}}" class="link-dark">{{$leader->nickname}}</a>
                </li>
                <li class="list-group-item">-------</li>
            </ul>
        </div>
        {{-- DEATHMATCH --}}
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

    <div class="row">
        {{-- MEMBROS --}}
            
        <div class="col mt-5">
            <label for="test">Membros</label>
            
            @if (count($members))
                <ul name="test" class="list-group list-group-flush">
                    @foreach ($members as $member)
                        <li class="list-group-item">
                            <mark>{{$index}}#</mark> 
                            <a href="/players/{{$member->id}}" class="link-dark">{{$member->nickname}}</a>
                        </li>
                        @php
                            $index++;
                        @endphp
                    @endforeach
                </ul>
            @else
                <p>ainda não possui membros</p>
            @endif
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
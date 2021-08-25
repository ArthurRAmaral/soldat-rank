@extends('adminlte::page')

@section('title', 'Perfil')

@section('content_header')
<form action="{{route('clan.logo')}}" method="post" enctype="multipart/form-data">
@csrf
    <div class="d-flex">
        <div>
            <span class="profile-box">
                <a id="openInput">
                    <img id="logoImg" class="rounded-circle p-1" height="70" width="70" src="/clans-logos/{{$clan->logo}}" alt="logo">
                    <i class="fas fa-edit fa-2x centered text-light fw-bold"></i>
                </a>
            </span> 
            <span class="fs-1 fw-bold align-middle">{!! $clan->name !!}</span>
        </div>

        <input type="file" onchange="loadFile(event)" name="newLogo" id="newLogoInput" hidden>
        <div>
            <button id="saveButton" type="submit" class="btn btn-outline-success py-2 mt-3 ms-4 align-middle" hidden>Salvar</button>
        </div>
        
    </div>
</form>
    
@stop

@php
    $index = 1;
@endphp

@section('content')

  <div class="container">
    <div class="row">
        {{-- clan details --}}
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
            </ul>
        </div>

        {{-- request list --}}
        @if (sizeof($joinRequests))
        <div class="col">
            <label for="test">Pedidos para entrar</label>
            <form action="{{route('clan.put')}}" method="post">
                @csrf
                <input type="hidden" name="clanId" value="{{$clan->id}}">
                <ul name="test" class="list-group list-group-flush">
                    @foreach ($joinRequests as $join)
                    <li class="list-group-item d-flex justify-content-between">
                        {{$join->nickname}}
                        <div>
                            <button type="submit" name="accept" value="{{$join->id}}" class="btn btn-success btn-sm">Aceitar</i></button>
                            <button type="submit" name="refuse" value="{{$join->id}}" class="btn btn-danger btn-sm">Recusar</button>
                        </div>
                        
                    </li>
                    @endforeach
                </ul>
            </form>
        </div>
        @endif
        

    </div>

    <div class="row">
        {{-- members --}}
        @if (sizeof($members))
        <div class="col mt-5">
            <label for="test">Membros</label>
            <form action="{{route('member.action')}}" method="post">
            @csrf
                <input type="hidden" name="clanId" value="{{$clan->id}}">
                <ul name="test" class="list-group list-group-flush">
                    @foreach ($members as $member)
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <mark>{{$index}}#</mark> 
                                <a href="/players/{{$member->id}}" class="link-dark">{{$member->nickname}}</a>
                            </div>
                            <div>
                                <button type="submit" name="promote" value="{{$member->id}}" class="btn btn-outline-warning btn-sm">Promover</button>
                                <button type="submit" name="kick_out" value="{{$member->id}}" class="btn btn-outline-danger btn-sm">Expulsar</button>
                            </div>
                        </li>
                        @php
                            $index++;
                        @endphp
                    @endforeach
                </ul>
            </form>   
        </div>
        @endif
        

        <div class="col mt-5">
            {{-- clan managers --}}
            <label for="test">Clã Managers</label>
            <form action="{{route('manager.action')}}" method="post">
            @csrf
                <input type="hidden" name="clanId" value="{{$clan->id}}">
                <ul name="test" class="list-group list-group-flush">
                    @foreach ($managers as $manager)
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <mark>{{$index}}#</mark> 
                                <a href="/players/{{$manager->id}}" class="link-dark">{{$manager->nickname}}</a>
                            </div>
                             @if ($isLeader)
                                <div>
                                    <button type="submit" name="demote" value="{{$manager->id}}" class="btn btn-outline-secondary btn-sm">Rebaixar</button>
                                    <button type="submit" name="kick_out" value="{{$manager->id}}" class="btn btn-outline-danger btn-sm">Expulsar</button>
                                </div>
                            @endif
                        </li>
                        @php
                            $index++;
                        @endphp
                    @endforeach
                </ul>
            </form>   
        </div>

    </div>
  </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .centered {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .profile-box {
            position: relative;
            text-align: center;
            color: white;
            cursor: pointer;
        }
    </style>
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        var newLogo = document.getElementById('newLogoInput');
        var open = document.getElementById('openInput');
        var saveButton = document.getElementById('saveButton');
        open.onclick = function(){
            newLogo.click();
        }

        var loadFile = function(event) {
            var logoImg = document.getElementById('logoImg');
            logoImg.src = URL.createObjectURL(event.target.files[0]);
            saveButton.hidden = false;
        };

    </script>
    @stop
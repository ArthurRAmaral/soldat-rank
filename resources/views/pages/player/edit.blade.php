@extends('adminlte::page')

@section('title', 'Perfil')

@section('content_header')

<h3>Editando perfil:</h3>
<div>
    <span class="container">
        <a id="openInput">
            <img id="logoImg" class="rounded-circle p-1" height="70" width="70" src="/players-logos/{{$player->logo}}" alt="logo">
            <i class="fas fa-edit fa-2x centered text-light fw-bold"></i>
        </a>
    </span> 
    <span class="fs-1 fw-bold align-middle">{!! $player->nickname !!}</span>
</div>
    
@stop


@section('content')

  <div class="container">
    <div class="row mt-4">

        <div class="col">
            <label for="test">Player</label>
            <ul name="test" class="list-group list-group-flush">
                <li class="list-group-item"><mark>Nome:</mark> {{$player->name}}</li>
                <li class="list-group-item"><mark>Nick:</mark> {{$player->nickname}}</li>
            </ul>
        </div>
    </div>
    <form action="{{route('player.update')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row mt-4">
            <input type="file" onchange="loadFile(event)" name="newLogo" id="newLogoInput" hidden>

            <button type="submit" class="btn btn-success mt-4">Salvar</button>
    </div>
    </form>
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
        .container {
            position: relative;
            text-align: center;
            color: white;
            cursor: pointer;
        }
    </style>
@stop

@section('js')
    <script>
        var newLogo = document.getElementById('newLogoInput');
        var open = document.getElementById('openInput');
        open.onclick = function(){
            newLogo.click();
        }

        var loadFile = function(event) {
            var logoImg = document.getElementById('logoImg');
            logoImg.src = URL.createObjectURL(event.target.files[0]);
        };

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@stop
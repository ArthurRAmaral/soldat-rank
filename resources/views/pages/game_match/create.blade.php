@extends('adminlte::page')

@section('title', 'Criar Campeonato')

@section('content_header')
    <h1 id="champid">Postar Partida</h1>
@stop

@section('content')
    <form action="{{ route('game_matches')}}" method="post">
        @csrf

        <!-- Championships Select -->
        <x-adminlte-select id="championship_id" label="Selecionar campeonato" name="championship_id">
            <option selected disabled>Selecione o campeonato:</option>
            @foreach ($championships as $champ)
                <option value="{{$champ->id}}">{{$champ->title}}</option>
            @endforeach
        </x-adminlte-select>

        <!--Draw Switch-->
        {{-- With custom text using data-* config --}}
        <x-adminlte-input-switch label="Foi empate?" id="draw" name="draw" data-on-text="SIM" data-off-text="NÃO"
        data-on-color="teal" checked/>

        
        <!-- Winner or Player1 -->
        <label id="l1" for="p1">Vencedor</label>
        <x-adminlte-select id="p1" name="player1">
            <option selected disabled>Selecione:</option>
            @foreach ($players as $player)
                <option value="{!! $player->id !!}">{!! $player->name !!}</option>
            @endforeach
        </x-adminlte-select>

         <!-- Loser or Player2-->
         <label id="l2" for="p2">Perdedor</label>
         <x-adminlte-select id="p2" name="player2">
            <option selected disabled>Selecione:</option>
            @foreach ($players as $player)
                <option value="{!! $player->id !!}">{!! $player->name !!}</option>
            @endforeach
        </x-adminlte-select>

         <!-- Image 1-->
         <x-adminlte-input name="img_1" label="Print do mapa 1" placeholder="Primeiro mapa"/>
          <!-- Championship 2 -->
        <x-adminlte-input name="img_2" label="Print do mapa 2" placeholder="Secundo mapa"/>
         <!-- Championship 3 -->
         <x-adminlte-input name="img_3" label="Print do mapa 3" placeholder="Terceiro mapa"/>

        <!-- Match Date -->
        @php
            $config = ['format' => 'DD-MM-YYYY'];
        @endphp
        <x-adminlte-input-date label="Informar data da partida" id="match_date" name="match_date" :config="$config"/>

        <x-adminlte-button type="submit" label="Enviar" theme="primary"/>

    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        var l1 = document.getElementById('l1');
        var l2 = document.getElementById('l2');
        var draw = document.getElementById('draw');

        draw.onchange = function(){
            if(draw.checked){
                l1.innerHTML = "Jogador 1";
                l2.innerHTML = "Jogador 2";
               
            }else{
                l1.innerHTML = "Vencedor"
                l2.innerHTML = "Perdedor"
            }
        }
    </script>
@stop
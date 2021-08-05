@extends('adminlte::page')

@section('title', 'Criar Campeonato')

@section('content_header')
    <h1>Criar Campeonato</h1>
@stop

@section('content')
    <form action="{{ route('game_matches')}}" method="post">
        @csrf

        <!-- Championships Select -->
        <x-adminlte-select label="Campeonato" id="championship" name="championship">
            <option selected disabled>Selecione o campeonato:</option>
            @foreach ($championships as $champ)
                <option value="{{$champ->id}}">{{$champ->title}}</option>
            @endforeach
        </x-adminlte-select>

        <!--Draw Switch-->
        {{-- With custom text using data-* config --}}
        <x-adminlte-input-switch label="Foi empate?" id="draw" name="draw" data-on-text="SIM" data-off-text="NÃO"
        data-on-color="teal" checked/>

        <!--Conditional rendering-->
        
        <!-- Winner or Player1 -->
        <x-adminlte-select label="Vencedor" id="p1" name="winner">
            <option selected disabled>Selecione:</option>
            @foreach ($players as $player)
                <option value="{!! $player->id !!}">{!! $player->name !!}</option>
            @endforeach
        </x-adminlte-select>

         <!-- Loser or Player2-->
         <x-adminlte-select label="Perdedor" id="p2" name="loser">
            <option selected disabled>Selecione:</option>
            @foreach ($players as $player)
                <option value="{!! $player->id !!}">{!! $player->name !!}</option>
            @endforeach
        </x-adminlte-select>

        <!-- Ending Date -->
        @php
            $config = ['format' => 'DD-MM-YYYY'];
        @endphp
        <x-adminlte-input-date label="Data final do campeonato" id="end" name="end" :config="$config"/>

        <x-adminlte-button type="submit" label="Enviar" theme="primary"/>

    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        var p1 = document.getElementById('p1');
        var p2 = document.getElementById('p2');
        var draw = document.getElementById('draw');

        draw.onchange = function(){
            if(draw.checked){
                p1.removeAttribute('label')
                p1.setAttribute('label', 'Jogador 1');
                p1.setAttribute('name', 'player1');
                p2.setAttribute('label', 'Jogador 2');
                p2.setAttribute('name', 'player2');
            }else{
                console.log(draw.checked)
            }
        }
    </script>
@stop
@extends('adminlte::page')

@section('title', 'Criar Campeonato')

@section('content_header')
    <h1 id="champid">Postar Partida</h1>
@stop

@section('content')
    <form action="{{ route('game_matches/create')}}" method="get">
        @csrf

        <!-- Championships Select -->
        <x-adminlte-select id="championship_id" label="Selecionar campeonato" name="championship_id">
            @foreach ($championships as $champ)
                <!--em value eu salvei de um modo que fique facil transformar em array utilizando a função js split()-->
                <option value="{{$champ->id}}">{{$champ->title}}</option>
            @endforeach
        </x-adminlte-select>

        <!--Draw Switch-->
        <x-adminlte-input-switch label="Foi empate?" id="draw" name="draw" data-on-text="SIM" data-off-text="NÃO"
        data-on-color="teal"/>


        <x-adminlte-button type="submit" label="Próximo >>" theme="success"/>

    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        
    </script>
@stop
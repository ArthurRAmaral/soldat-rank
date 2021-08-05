@extends('adminlte::page')

@section('title', 'Criar Campeonato')

@section('content_header')
    <h1>Criar Campeonato</h1>
@stop

@section('content')
    <form action="{{ route('championships')}}" method="post">
        @csrf

        <!-- Championship title -->
        <x-adminlte-input name="title" label="Título do Campeonato" placeholder="Título"/>

        @if($errors->has('title'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('title') }}</strong>
            </div>
        @endif

        
        <!-- Gamemode -->
        <x-adminlte-select label="Modo de Jogo" id="game_mode" name="game_mode">
            <option selected disabled>Selecione:</option>
            <option value="cf">CF</option>
            <option value="x1">X1</option>
        </x-adminlte-select>

        <!-- Ending Date -->
        @php
            $config = ['format' => 'DD-MM-YYYY'];
        @endphp
        <x-adminlte-input-date label="Data final do campeonato" id="end" name="end" :config="$config"/>

        <x-adminlte-button type="submit" label="Criar" theme="primary"/>

    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
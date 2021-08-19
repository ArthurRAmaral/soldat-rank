@extends('adminlte::page')

@section('title', 'Gerenciar DM')

@section('content_header')
    <h1>Validar Partidas DM</h1>
@stop

{{-- Setup data for datatables --}}
@php

$index = 0;

@endphp

@section('content')

<form action="{{ route('dm_validate') }}" method="post">
@csrf

 <table class="table table-striped table-dark table-hover">
    <thead>
        <tr>
          <th scope="col">Vencedor</th>
          <th scope="col">Perdedor</th>
          <th scope="col">Mapa 1</th>
          <th scope="col">Mapa 2</th>
          <th scope="col">Mapa 3</th>
          <th scope="col">Data</th>
          <th scope="col">Aceitar</th>
          <th scope="col">Recusar</th>
        </tr>
      </thead>
     
      <tbody>
        @foreach ($matches as $match)   
        <tr>
            <td>{!! $match->winnerName !!}</td>
            <td>{!! $match->loserName !!}</td>
            <td>
                <x-adminlte-modal id="map1{!! $index !!}" title="Theme Purple" theme="dark"
                    icon="fas fa-bolt" size='lg' disable-animations>
                    <img src="{!! "/images/" . $match->screen1 !!}" alt="O print da partida falhou" height="450" width="700">
                </x-adminlte-modal>
                <x-adminlte-button label="Mapa 1" data-toggle="modal" data-target="#map1{!! $index !!}" class="bg-dark"/>
            </td>

            <td>
                <x-adminlte-modal id="map2{!! $index !!}" title="Theme Purple" theme="dark"
                    icon="fas fa-bolt" size='lg' disable-animations>
                    <img src="{!! "/images/" . $match->screen2 !!}" alt="O print da partida falhou" height="450" width="700">
                </x-adminlte-modal>
                <x-adminlte-button label="Mapa 2" data-toggle="modal" data-target="#map2{!! $index !!}" class="bg-dark"/>
            </td>

            <td>
                <x-adminlte-modal id="map3{!! $index !!}" title="Theme Purple" theme="dark"
                    icon="fas fa-bolt" size='lg' disable-animations>
                    <img src="{!! "/images/" . $match->screen3 !!}" alt="O print da partida falhou" height="450" width="700">
                </x-adminlte-modal>
                <x-adminlte-button label="Mapa 3" data-toggle="modal" data-target="#map3{!! $index !!}" class="bg-dark"/>
            </td>
            
            <td>{!! $match->match_date !!}</td>

            <td><x-adminlte-button type="submit" name="accept" value="{{$match->matchId}}"  theme="success" icon="fas fa-thumbs-up"/></td>
            <td><x-adminlte-button type="submit" name="refuse" value="{{$match->matchId}}" theme="danger" icon="fas fa-thumbs-down"/></td>
          </tr>
            @php
                $index++;
            @endphp
        @endforeach
      </tbody>
    
  </table>
</form>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@stop
@extends('adminlte::page')

@section('title', 'Clãs')

@section('content_header')
    <h1>Todos os Clãs</h1>
@stop

{{-- Setup data for datatables --}}
@php
$heads = [
    'Data',
    'Winner',
    'Loser',
    'Mapa 1',
    'Mapa 2',
    'Mapa 3',
];

$btnEdit = '';
$btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                  <i class="fa fa-lg fa-fw fa-trash"></i>
              </button>';
$btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                   <i class="fa fa-lg fa-fw fa-eye"></i>
               </button>';

$config = [
    'data' => [
        ['Jogador 1', 'Jogador 2', '<nobr>'. $btnEdit . '</nobr>', '<nobr>'. $btnDelete . '</nobr>', '<nobr>'. $btnDetails . '</nobr>'],
        ['Jogador 1', 'Jogador 2', '<nobr>'. $btnEdit . '</nobr>', '<nobr>'. $btnDelete . '</nobr>', '<nobr>'. $btnDetails . '</nobr>'],
        ['Jogador 1', 'Jogador 2', '<nobr>'. $btnEdit . '</nobr>', '<nobr>'. $btnDelete . '</nobr>', '<nobr>'. $btnDetails . '</nobr>'],
    ],
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, null, null],
];

$modalIndex = 0;
@endphp

@section('content')

<table class="table table-striped table-dark table-hover">
    <thead>
        <tr>
          <th scope="col">Vencedor</th>
          <th scope="col">Perdedor</th>
          <th scope="col">Mapa 1</th>
          <th scope="col">Mapa 2</th>
          <th scope="col">Mapa 3</th>
          <th scope="col">Data</th>
        </tr>
      </thead>
     
      <tbody>
        @foreach ($matches as $match)
        <tr>
            <td>{!! $match->winner_name !!}</td>
            <td>{!! $match->loser_name !!}</td>
            <td>
                <x-adminlte-modal id="map1{!! $modalIndex !!}" title="Theme Purple" theme="dark"
                    icon="fas fa-bolt" size='lg' disable-animations>
                    <img src="{!! "/images/" . $match->img[0] !!}" alt="O print da partida falhou" height="450" width="700">
                </x-adminlte-modal>
                <x-adminlte-button label="Mapa 1" data-toggle="modal" data-target="#map1{!! $modalIndex !!}" class="bg-dark"/>
            </td>

            <td>
                <x-adminlte-modal id="map2{!! $modalIndex !!}" title="Theme Purple" theme="dark"
                    icon="fas fa-bolt" size='lg' disable-animations>
                    <img src="{!! "/images/" . $match->img[1] !!}" alt="O print da partida falhou" height="450" width="700">
                </x-adminlte-modal>
                <x-adminlte-button label="Mapa 2" data-toggle="modal" data-target="#map2{!! $modalIndex !!}" class="bg-dark"/>
            </td>

            <td>
                <x-adminlte-modal id="map3{!! $modalIndex !!}" title="Theme Purple" theme="dark"
                    icon="fas fa-bolt" size='lg' disable-animations>
                    <img src="{!! "/images/" . $match->img[2] !!}" alt="O print da partida falhou" height="450" width="700">
                </x-adminlte-modal>
                <x-adminlte-button label="Mapa 3" data-toggle="modal" data-target="#map3{!! $modalIndex !!}" class="bg-dark"/>
            </td>
            <td>{!! $match->match_date !!}</td>
          </tr>
            @php
                $modalIndex++;
            @endphp
        @endforeach
      </tbody>
    
  </table>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@stop
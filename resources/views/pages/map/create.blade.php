@extends('adminlte::page')

@section('title', 'Cadastrar Clã')

@section('content_header')
    <h1>Cadastrar Clã</h1>
@stop

@php
$heads = [
    'Map Name',
];

$config = [
    'data' => $maps,
    'order' => [[1, 'asc']],
    'columns' => [['orderable' => false]],
];

$i = 0;
@endphp

@section('content')
    {{-- create new map --}}
    <div>teste</div>
    <form action="{{ route('mapnames')}}" method="post">
        @csrf

            <div class="row">
                <x-adminlte-input name="name" label="Nome do Mapa" placeholder="Nome do mapa"
                    fgroup-class="col-md-6" disable-feedback/>
            </div>

        <x-adminlte-button type="submit" label="Adicionar" theme="primary"/>

    </form>

    {{-- map list --}}
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach ($maps as $map)
            <tr>
                <td>{{$map->name}}</td>
            </tr>
        @endforeach
    </x-adminlte-datatable>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
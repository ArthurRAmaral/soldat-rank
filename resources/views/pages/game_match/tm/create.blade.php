@extends('adminlte::page')

@section('title', 'Temporada de Death Match')

@section('content_header')
    <h1 class="p-3" id="champid">Postar Partida de CF</h1>
@stop

@php

@endphp

@section('content')
    <form action="{{ route('game_match/tm')}}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="container">


            <div class="row">
                <div class="col p-3">
                    <!-- Winner or clan 1 -->
                    <label for="clan1">Meu clã</label>
                    <x-adminlte-select id="clan1" name="clan1">
                        <option value="{!! $playerClan->id !!}">{!! $playerClan->name !!}</option>
                    </x-adminlte-select>
                </div>
                <div class="col p-3">
                    <!-- Loser or clan 2-->
                    <label for="clan2">Clã adversário</label>
                    <x-adminlte-select id="clan2" name="clan2">
                        <option selected disabled>Selecione:</option>
                        @foreach ($clans as $clan)
                            <option value="{!! $clan->id !!}">{!! $clan->name !!}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- INFORMAÇÕES DO PRIMEIRO MAPA --}}
            <div class="col">
                <label for="1map-column" class="fs-3">Primeiro Mapa</label>
                <div id="1map-column" name="1map-column" class="p-2 border">
                    <!--Map name 1-->
                    <div class="row">
                        <label for="name_map1">Mapa</label>
                        <x-adminlte-select id="name_map1" name="name_map1">
                            <option selected disabled>Selecione:</option>
                            @foreach ($map_names as $map)
                                <option value="{!! $map->id !!}">{!! $map->name !!}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>

                    <!--Pontos do meu clã-->
                    <div class="row">
                        <x-adminlte-input name="clan1_points_map1" type="number" label="Pontos do meu clã" placeholder="Pontos {{$playerClan->name}}..."
                            fgroup-class="col-md-6"/>
                    </div>

                    <!--Pontos do clã adversário-->
                    <div class="row">
                        <x-adminlte-input name="clan2_points_map1" type="number" label="Pontos do adversário" placeholder="Pontos adversário..."
                            fgroup-class="col-md-6"/>
                    </div>

                    <!-- Image 1-->
                    <x-adminlte-input-file name="img_1" label="Print" placeholder="Choose a file...">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-lightblue">
                                <i class="fas fa-upload"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-file>
                </div>
            </div>

            {{-- INFORMAÇÕES DO SEGUNDO MAPA --}}
            <div class="col">
                <label for="2map-column" class="fs-3">Segundo Mapa</label>
                <div id="2map-column" name="2map-column" class="p-2 border">
                    <!--Map name 1-->
                    <div class="row">
                        <label for="name_map2">Mapa</label>
                        <x-adminlte-select id="name_map2" name="name_map2">
                            <option selected disabled>Selecione:</option>
                            @foreach ($map_names as $map)
                                <option value="{!! $map->id !!}">{!! $map->name !!}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>

                    <!--Pontos do clã 1-->
                    <div class="row">
                        <x-adminlte-input name="clan1_points_map2" type="number" label="Pontos do meu clã" placeholder="Pontos {{$playerClan->name}}..."
                            fgroup-class="col-md-6"/>
                    </div>

                    <!--Pontos do clã 2-->
                    <div class="row">
                        <x-adminlte-input name="clan2_points_map2" type="number" label="Pontos do adversário" placeholder="Pontos adversário..."
                            fgroup-class="col-md-6"/>
                    </div>

                    <!-- Image 1-->
                    <x-adminlte-input-file name="img_2" label="Print" placeholder="Choose a file...">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-lightblue">
                                <i class="fas fa-upload"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-file>
                </div>
            </div>
            
           {{-- INFORMAÇÕES DO TERCEIRO MAPA --}}
           <div class="col">
                <label for="3map-column" class="fs-3">Terceiro Mapa</label>
                <div id="3map-column" name="3map-column" class="p-2 border">
                    <!--Map name 1-->
                    <div class="row">
                        <label for="name_map3">Mapa</label>
                        <x-adminlte-select id="name_map3" name="name_map3">
                            <option selected disabled>Selecione:</option>
                            @foreach ($map_names as $map)
                                <option value="{!! $map->id !!}">{!! $map->name !!}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>

                    <!--Pontos do clã 1-->
                    <div class="row">
                        <x-adminlte-input name="clan1_points_map3" type="number" label="Pontos do meu clã" placeholder="Pontos {{$playerClan->name}}..."
                            fgroup-class="col-md-6"/>
                    </div>

                    <!--Pontos do clã 2-->
                    <div class="row">
                        <x-adminlte-input name="clan2_points_map3" type="number" label="Pontos do adversário" placeholder="Pontos adversário..."
                            fgroup-class="col-md-6"/>
                    </div>

                    <!-- Image 1-->
                    <x-adminlte-input-file name="img_3" label="Print" placeholder="Choose a file...">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-lightblue">
                                <i class="fas fa-upload"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-file>
                </div>
            </div>
        </div>
        

        
 

         
         

        <!-- Match Date -->
        @php
           $config = [
                'format' => 'DD-MM-YYYY',
                'dayViewHeaderFormat' => 'MMM YYYY',
                'minDate' => "js:moment().startOf('month')",
                'maxDate' => $dateNow,
            ];
            $textPlaceHolder = "Algum clã deixou a partida? O adversário desistiu? Algúem é emprestado? Outra informação adicional relevante?";
        @endphp

        <label for="match_date" class="mt-4">Data da partida</label>
        <x-adminlte-input-date class="mb-4" maxDate="{!! $dateNow !!}" id="match_date" name="match_date" :config="$config"/>

        <x-adminlte-textarea label="Informações adicionais:" name="comment" placeholder="{{$textPlaceHolder}}"/>
        
        <x-adminlte-button type="submit" label="Enviar" theme="primary"/>

    </form>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    </script>
@stop
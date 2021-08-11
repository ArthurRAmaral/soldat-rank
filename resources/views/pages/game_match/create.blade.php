@extends('adminlte::page')

@section('title', 'Criar Campeonato')

@section('content_header')
    <h1 id="champid">Postar Partida</h1>
@stop

@php

@endphp

@section('content')
    <form id="return" action="{{route('game_matches/create')}}" method="get"></form>
    <form action="{{ route('game_matches')}}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="container">
            <div class="row">
                <div class="col">
                    {{-- Championship selected --}}
                    <x-adminlte-select readonly="true" id="championship_id" label="Selecionar campeonato" name="championship_id">
                        <option selected value="{!! $championship->id !!}">{!! $championship->title !!}</option>
                    </x-adminlte-select>

                    <!--Draw Switch-->
                    @if ($draw)
                        <x-adminlte-input-switch label="Foi empate?" id="draw" name="draw" data-on-text="SIM" data-off-text="NÃO"
                        data-on-color="teal" checked disabled />
                    @else
                        <x-adminlte-input-switch label="Foi empate?" id="draw" name="draw" data-on-text="SIM" data-off-text="NÃO"
                        data-on-color="teal" disabled />
                    @endif
                </div>
                <!-- Championships Select -->
        
            </div>


            <div class="row">
                <div class="col">
                    <!-- Winner or Competitor 1 -->
                    <label for="competitor1">{!! $label1 !!}</label>
                    <x-adminlte-select id="competitor1" name="competitor1">
                        <option selected disabled>Selecione:</option>
                        @foreach ($competitors as $competitor)
                            <option value="{!! $competitor->id !!}">{!! $competitor->name !!}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>

                <div class="col">
                    <!-- Loser or Competitor 2-->
                    <label for="competitor2">{!! $label2 !!}</label>
                    <x-adminlte-select id="competitor2" name="competitor2">
                        <option selected disabled>Selecione:</option>
                        @foreach ($competitors as $competitor)
                            <option value="{!! $competitor->id !!}">{!! $competitor->name !!}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <!-- Image 1-->
                <x-adminlte-input-file name="img_1" label="Print do mapa 1" placeholder="Choose a file...">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-lightblue">
                            <i class="fas fa-upload"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-file>
            </div>

            <div class="col">
                <!-- Image 2 -->
                <x-adminlte-input-file name="img_2" label="Print do mapa 2" placeholder="Choose a file...">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-lightblue">
                            <i class="fas fa-upload"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-file>
            </div>

            <div class="col">
                <!-- Image 3 -->
                <x-adminlte-input-file name="img_3" label="Print do mapa 3" placeholder="Choose a file...">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-lightblue">
                            <i class="fas fa-upload"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-file>
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
        @endphp

        <x-adminlte-input-date maxDate="{!! $dateNow !!}" label="Informar data da partida" id="match_date" name="match_date" :config="$config"/>

        
        <a href="{{ url()->previous() }}" >
            <x-adminlte-button type="button" form="return" label="<< Voltar" theme="warning"/>
        </a>
        
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
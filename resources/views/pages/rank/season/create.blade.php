@extends('adminlte::page')

@section('title', 'Perfil')

@section('content_header')
    <h2>Criar novo Rank pra temporada de {{$gameMode}}</h2>
@stop


@section('content')
    <div class="container">  
        <div class="row mt-4">
            <form action="{{route('seasons')}}" method="post">
            @csrf
            <div class="col p-4">
                <div class="row">
                    
                    <div class="d-flex flex-column">
                        <input class="form-control form-control-lg text-center fs-2 text" name="rankTitle" type="text" placeholder="Escolha um título relevante" aria-label=".form-control-lg example" required>
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-column">
                                <p class="fs-5 text align-self-center">Inicio</p>
                                <p>{{$dateNow}}</p>
                            </div>
                            <div class="d-flex flex-column">
                                <p class="fs-5 text align-self-center">Fim</p>
                                <!-- END DATE -->
                                @php
                                $config = [
                                     'format' => 'DD/MM/YYYY',
                                     'dayViewHeaderFormat' => 'MMM YYYY',
                                     'minDate' => $minDate,
                                     'timezone' => 'America/Sao_Paulo'
                                 ];
                             @endphp
                             <x-adminlte-input-date class="mb-4 text-center" language="pt-BR" id="endDate" name="endDate" value="{{$dateNow}}" placeholder="data final..." :config="$config"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <input type="hidden" name="endingRank" value="{{$endingRank}}">
                    <button type="submit" class="btn btn-warning mt-4">Criar novo Rank e finalizar o antigo</button>
                </div>             
            </div>
        </form>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@stop
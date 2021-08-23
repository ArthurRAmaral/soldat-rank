@extends('adminlte::page')

@section('title', 'Perfil')

@section('content_header')

@stop


@section('content')
    <div class="container">
    
        <div class="d-flex justify-content-between p-3 mt-2">
            <h2>Alterar título ou data final</h2>
            <form action="{{route('seasons.delete')}}" method="post">
            @csrf
                <input type="hidden" name="gameMode" value="{{$activeRank->game_mode}}">
                <input type="hidden" name="rankToDelete" value="{{$activeRank->id}}">
                <button type="submit" class="btn btn-outline-danger">Finalizar temporada atual e iniciar uma nova</button>
            </form>
        </div>
        <div class="row mt-4">
            <form action="{{route('seasons.update')}}" method="post">
            @csrf
            <div class="col p-4">
                <div class="row">
                    
                    <div class="d-flex flex-column">
                        <input class="form-control form-control-lg text-center fs-2 text" name="rankTitle" type="text" placeholder="{{$activeRank->title}}" value="{{$activeRank->title}}" aria-label=".form-control-lg example">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-column">
                                <p class="fs-5 text align-self-center">Inicio</p>
                                <p>{{$rankStart}}</p>
                            </div>
                            <div class="d-flex flex-column">
                                <p class="fs-5 text align-self-center">Fim</p>
                                <!-- END DATE -->
                                @php
                                $config = [
                                     'format' => 'DD/MM/YYYY',
                                     'dayViewHeaderFormat' => 'MMM YYYY',
                                     'minDate' => $dateNow,
                                     'language' => 'pt-BR'
                                 ];
                             @endphp
                             <x-adminlte-input-date class="mb-4 text-center" language="pt-BR" id="match_date" name="endDate" value="{{$rankEnd}}" placeholder="{{$rankEnd}}" :config="$config"/>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{$rankPercent}}%;" aria-valuenow="{{$rankPercent}}" aria-valuemin="0" aria-valuemax="100">{{$rankPercent}}%</div>
                        </div>
                        <p class="align-self-center fs-6">Faltam <span class="fs-5 text text-info">{{$daysLeft}}</span> dias</p>
                        <div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <input type="hidden" name="rankId" value="{{$activeRank->id}}">
                    <button type="submit" class="btn btn-success mt-4">Salvar Alterações</button>
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
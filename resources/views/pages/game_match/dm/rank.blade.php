@extends('adminlte::page')

@section('title', 'Torneio DM')

@section('content_header')
    <h1>Rank de X1</h1>
@stop

@section('content')

 <table class="table table-striped table-dark table-hover">
    <thead>
        <tr>
            <th scope="col">Nick</th>
            <th scope="col">Pontos</th>
            <th scope="col">Vitórias</th>
            <th scope="col">Derrotas</th>
            <th scope="col">Empates</th>
            <th scope="col">Total de Partidas</th>
        </tr>
      </thead>
     
      <tbody>

        @foreach ($matchHistories as $history)   
        <tr>
            <td>              
              <div>
                <a class="text-light" href="/players/{{$history->userId}}">
                  <img class="rounded-circle p-1" height="40" width="40" src="/players-logos/{{$history->logo}}" alt="logo">
                </a>
                <a class="text-light" href="/players/{{$history->userId}}">
                  <span class="fs-6 fw-bold align-middle">{!! $history->nickname !!}</span>
                </a>
              </div>
            </td>
            <td>{!! $history->points !!}</td>
            <td>{!! $history->wins !!}</td>
            <td>{!! $history->losses !!}</td>
            <td>{!! $history->draws !!}</td>
            <td>{!! $history->wins + $history->losses + $history->draws !!}</td>
          </tr>
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
@extends('adminlte::page')

@section('title', 'Gerenciar TM')

@section('content_header')
    <h1>Validar Partidas TM</h1>
@stop

{{-- Setup data for datatables --}}
@php

$index = 0;

@endphp

@section('content')

<div class="container">
    <div class="row">
        <table class="table table-striped table-dark table-hover">
            <thead>
                <tr>
                  <th scope="col">Clã</th>
                  <th scope="col">Score</th>
                  <th scope="col">Mapas</th>
                  <th scope="col">Informações</th>
                  <th scope="col">Data</th>
                  <th scope="col">Aceitar</th>
                  <th scope="col">Recusar</th>
                </tr>
              </thead>
             
              <tbody>
        
                @foreach ($matches as $match)   
                <tr>
                    <td>
                        <div class="container p-1">
                            <div class="row">
                               <p class="fs-6">{{$match->winnerName}}</p>
                            </div>
                            <div class="row">
                                <p class="fs-6">{{$match->loserName}}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="container p-1">
                            <div class="row">
                               <p class="fs-6">{{$match->total_score_winner}}</p>
                            </div>
                            <div class="row">
                                <p class="fs-6">{{$match->total_score_loser}}</p>
                            </div>
                        </div>
                    </td>
                    <td>
        
                        <!-- MAPS MODEL BEGINNNNNNNNNNNNNNNNNNNNNNNNNNNN -->
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-dark mt-3" data-bs-toggle="modal" data-bs-target="#map{!! $index !!}">
                            Ver
                        </button>
                                        <!--Modal -->
                        <div class="modal fade" id="map{!! $index !!}" tabindex="-1" aria-labelledby="exampleModalLabel{!!$index!!}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-dark">
                                <h5 class="modal-title" id="exampleModalLabel{!!$index!!}">{!! $match->winnerName !!} vs {!! $match->loserName !!}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body bg-dark">
                                    <div id="carouselExampleCaptions{!!$index!!}" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                        <div class="carousel-indicators">
                                          <button type="button" data-bs-target="#carouselExampleCaptions{!!$index!!}" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                          <button type="button" data-bs-target="#carouselExampleCaptions{!!$index!!}" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                          <button type="button" data-bs-target="#carouselExampleCaptions{!!$index!!}" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                        </div>
                                        <div class="carousel-inner">
                                          <div class="carousel-item active">
                                            <img src="{!! "/images/" . $match->screen1 !!}" class="d-block w-100 rounded" alt="...">
                                            <div class="carousel-caption d-none d-md-block">
                                              <h3>Primeiro mapa: <span class="text-warning">{{$match->mapName1}}</span></h5>
                                              <div>
                                                <p class="fs-4 text text-warning"><span class="bg-dark text-light rounded p-1">{{$match->winnerName}}: <span class="text-warning">{{$match->score_winner1}}</span></span></p>
                                                <p class="fs-4 text text-warning"><span class="bg-dark text-light rounded p-1">{{$match->loserName}}: <span class="text-warning">{{$match->score_loser1}}</span></span></p>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="carousel-item">
                                            <img src="{!! "/images/" . $match->screen2 !!}" class="d-block w-100 rounded" alt="...">
                                            <div class="carousel-caption d-none d-md-block">
                                              <h3>Segundo mapa: <span class="text-warning">{{$match->mapName2}}</span></h5>
                                              <div>
                                                <p class="fs-4 text text-warning"><span class="bg-dark text-light rounded p-1">{{$match->winnerName}}: <span class="text-warning">{{$match->score_winner2}}</span></span></p>
                                                <p class="fs-4 text text-warning"><span class="bg-dark text-light rounded p-1">{{$match->loserName}}: <span class="text-warning">{{$match->score_loser2}}</span></span></p>
                                              </div>
                                            </div>
                                          </div>
                                          @if(isset($match->screen3))
                                            <div class="carousel-item">
                                                <img src="{!! "/images/" . $match->screen3 !!}" class="d-block w-100 rounded" alt="...">
                                                <div class="carousel-caption d-none d-md-block">
                                                <h3>Terceiro mapa: <span class="text-warning">{{$match->mapName3}}</span></h5>
                                                <div>
                                                  <p class="fs-4 text text-warning"><span class="bg-dark text-light rounded p-1">{{$match->winnerName}}: <span class="text-warning">{{$match->score_winner3}}</span></span></p>
                                                  <p class="fs-4 text text-warning"><span class="bg-dark text-light rounded p-1">{{$match->loserName}}: <span class="text-warning">{{$match->score_loser3}}</span></span></p>
                                                </div>
                                                </div>
                                            </div>
                                          @endif
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions{!!$index!!}" data-bs-slide="prev">
                                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                          <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions{!!$index!!}" data-bs-slide="next">
                                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                          <span class="visually-hidden">Next</span>
                                        </button>
                                      </div>
                                </div>
                                <div class="modal-footer bg-dark">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </td>
           
                    <!--INFO Modal-->
                    <td>
                              <!-- Button trigger modal -->
                        <button type="button" class="btn btn-dark mt-3" data-bs-toggle="modal" data-bs-target="#messageModel{!!$index!!}">
                            Ver
                        </button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="messageModel{!!$index!!}" tabindex="-1" aria-labelledby="messageModalLabel{!!$index!!}" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-dark">
                                <h5 class="modal-title" id="messageModalLabel{!!$index!!}">Informações</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <!-- Modal Body with info -->
                                <div class="modal-body bg-dark">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-start bg-dark">
                                          <div class="ms-2 me-auto">
                                            <div class="fw-bold">Vencedor</div>
                                            <a class="text-light" href="/clans/{{$match->winnerId}}">{{$match->winnerName}}</a>
                                          </div>
                                          <span class="fs-4 text-success">+{{$match->delta_winner}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start bg-dark">
                                          <div class="ms-2 me-auto">
                                            <div class="fw-bold">Perdedor</div>
                                            <a class="text-light" href="/clans/{{$match->loserId}}">{{$match->loserName}}</a>
                                            
                                          </div>
                                          <span class="fs-4 text-danger">{{$match->delta_loser}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start bg-dark">
                                          <div class="ms-2 me-auto">
                                            <div class="fw-bold">Comentário</div>
                                            @if(isset($match->submitter_comment))
                                                {{$match->submitter_comment}}
                                            @else
                                                nenhum
                                            @endif
                                          </div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start bg-dark">
                                            <div class="ms-2 me-auto">
                                              <div class="fw-bold">CF postado por:</div>
                                              <a class="text-light" href="/players/{{$match->submitterId}}">{{$match->submitterNickname}}</a>
                                            </div>
                                          </li>
                                          <li class="list-group-item d-flex justify-content-between align-items-start bg-dark">
                                            <div class="ms-2 me-auto">
                                              <div class="fw-bold">Data de postagem:</div>
                                              {{$match->created_match_date}}
                                            </div>
                                          </li>
                                          <li class="list-group-item d-flex justify-content-between align-items-start bg-dark">
                                            <div class="ms-2 me-auto">
                                              <div class="fw-bold">Data do CF:</div>
                                              {{$match->match_date}}
                                            </div>
                                          </li>
                                    </ul>
                                </div>
                                <div class="modal-footer bg-dark">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </td>
                    <!--Date -->
                    <td><p class="mt-4">{!! $match->match_date !!}</p></td>

                    <!-- Accept and refuse buttons -->
                    <td><x-adminlte-button class="mt-3" type="submit" name="accept" value="{{$match->matchId}}"  theme="success" icon="fas fa-thumbs-up"/></td>
                    <td><x-adminlte-button class="mt-3" type="submit" name="refuse" value="{{$match->matchId}}" theme="danger" icon="fas fa-thumbs-down"/></td>
                  </tr>
                    @php
                        $index++;
                    @endphp
                @endforeach
              </tbody>
          </table>
    </div>
    <div class="row">
        <span>{{$matches->links()}}</span>
    </div>
</div>

@stop

{{--
     <td><x-adminlte-button type="submit" name="accept" value="{{$match->matchId}}"  theme="success" icon="fas fa-thumbs-up"/></td>
    <td><x-adminlte-button type="submit" name="refuse" value="{{$match->matchId}}" theme="danger" icon="fas fa-thumbs-down"/></td>
    
<form action="{{ route('tm_validate') }}" method="post">
@csrf
</form>
    
        --}}

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@stop
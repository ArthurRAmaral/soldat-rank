@extends('adminlte::page')

@section('title', 'Players')

@section('content_header')
    <h1>Todos os Players</h1>
@stop

{{-- Setup data for datatables PHPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPP--}}
@php
$heads = [
    'Player',
    'Privilegios',
];

$config = [
    'data' => $players,
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, ['orderable' => false]],
];

$i = 0;
@endphp

@section('content')
        {{-- Minimal example / fill data using the component slot --}}
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach($config['data'] as $row)
            <tr>
                <td>
                    <div>
                        <a class="text-light" href="/players/{{$row->userId}}">
                          <img class="rounded-circle p-1" height="40" width="40" src="/players-logos/{{$row->userLogo}}" alt="logo">
                        </a>
                        <span class="fs-6 fw-bold align-middle">
                            <a class="text-dark" href="/clans/{{$row->clanId}}">{!! $row->clanTag !!}</a> <a class="text-dark" href="/players/{{$row->userId}}">{!! $row->nickname !!}</a>
                        </span>
                    </div>
                </td>

                <td>
                    <div>
                        @if ($row->is_validator)
                            <span class="text-success me-1">validator</span>
                        @endif
                        @if ($row->isAdmin)
                            <span class="text-warning me-1">admin</span>
                        @endif
                        @if ($row->is_superuser)
                            <span class="text-danger">superuser</span>
                        @endif
                    </div>
                </td>
                    
                <td class="d-flex justify-content-end">
                    <div class="dropdown me-4">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                          Ações
                        </button>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            @if (!$row->is_superuser)
                                @if(!$row->isAdmin)
                                    @if (!$row->is_validator)
                                        <li>
                                            <form action="{{route('promote.validator')}}" method="post">
                                            @csrf
                                                <input type="hidden" name="userId" value="{{$row->userId}}">
                                                <button type="submit" class="dropdown-item text-success">Promover Validator</button>
                                            </form>
                                        </li>
                                    @else
                                    <li>
                                        <form action="{{route('demote.validator')}}" method="post">
                                        @csrf
                                            <input type="hidden" name="userId" value="{{$row->userId}}">
                                            <button type="submit" class="dropdown-item">Remover Validator</button>
                                        </form>
                                    </li>
                                    @endif
                                    <li>
                                    <form action="{{route('promote.admin')}}" method="post">
                                    @csrf
                                        <input type="hidden" name="userId" value="{{$row->userId}}">
                                        <button type="submit" class="dropdown-item text-warning">Promover Admin</button>
                                    </form>
                                    </li>
                                @else
                                    <li>
                                    <form action="{{route('demote.admin')}}" method="post">
                                    @csrf
                                        <input type="hidden" name="userId" value="{{$row->userId}}">
                                        <button type="submit" class="dropdown-item">Remover Admin</button>
                                    </form>
                                    </li>
                                @endif
                                <li>
                                <form action="{{route('promote.superuser')}}" method="post">
                                @csrf
                                    <input type="hidden" name="userId" value="{{$row->userId}}">
                                    <button type="submit" class="dropdown-item text-danger">Promover Superuser</button>
                                </form>
                                </li>
                                <!-- divider -->
                                <li><hr class="dropdown-divider"></li>

                                <li>
                                <form action="{{route('player.destroy')}}" method="post">
                                @csrf
                                    <input type="hidden" name="userId" value="{{$row->userId}}">
                                    <button type="submit" class="dropdown-item text-danger">Banir</button>
                                </form>
                                </li>
                            @else
                                <li>
                                <form action="{{route('demote.superuser')}}" method="post">
                                @csrf
                                    <input type="hidden" name="userId" value="{{$row->userId}}">
                                    <button type="submit" class="dropdown-item text-warning text-danger">Remover Superuser</button>
                                </form>
                                </li>
                            @endif
                        </ul>
                      </div>


                      {{--
                      <div class="d-flex">
                        @if (!$row->is_superuser)
                            @if(!$row->isAdmin)
                                @if (!$row->is_validator)
                                    <form action="{{route('promote.validator')}}" method="post">
                                    @csrf
                                        <input type="hidden" name="userId" value="{{$row->userId}}">
                                        <button type="submit" class="dropdown-item">Promover Validator</button>
                                    </form>
                                @else
                                    <form action="{{route('demote.validator')}}" method="post">
                                    @csrf
                                        <input type="hidden" name="userId" value="{{$row->userId}}">
                                        <button type="submit" class="dropdown-item">Remover Validator</button>
                                    </form>
                                @endif
                                
                                <form action="{{route('promote.admin')}}" method="post">
                                @csrf
                                    <input type="hidden" name="userId" value="{{$row->userId}}">
                                    <button type="submit" class="dropdown-item">Promover Admin</button>
                                </form>
                                
                            @else
                                <form action="{{route('demote.admin')}}" method="post">
                                @csrf
                                    <input type="hidden" name="userId" value="{{$row->userId}}">
                                    <button type="submit" class="btn btn-outline-secondary">Remover Admin</button>
                                </form>
                            @endif

                            <form class="mx-2" action="{{route('promote.superuser')}}" method="post">
                            @csrf
                                <input type="hidden" name="userId" value="{{$row->userId}}">
                                <button type="submit" class="btn btn-outline-danger">Promover Superuser</button>
                            </form>

                            <form action="{{route('player.destroy')}}" method="post">
                            @csrf
                                <input type="hidden" name="userId" value="{{$row->userId}}">
                                <button type="submit" class="btn btn-outline-danger">Banir</button>
                            </form>
                        @else
                            <form action="{{route('demote.superuser')}}" method="post">
                            @csrf
                                <input type="hidden" name="userId" value="{{$row->userId}}">
                                <button type="submit" class="btn btn-outline-danger">Remover Superuser</button>
                            </form>
                        @endif
                        
                        
                        
                      </div>
                    --}}
                </td>

                @php
                    $i++;
                @endphp
            </tr>
        @endforeach
    </x-adminlte-datatable>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        a {
            text-decoration: none;
        }
        a:hover {
            cursor: pointer;
            text-decoration:underline;
        }
    </style>
    @stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@stop
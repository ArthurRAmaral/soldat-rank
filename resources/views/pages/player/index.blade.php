@extends('adminlte::page')

@section('title', 'Players')

@section('content_header')
    <h1>Todos os Players</h1>
@stop

{{-- Setup data for datatables PHPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPP--}}
@php
$heads = [
    'Player',
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
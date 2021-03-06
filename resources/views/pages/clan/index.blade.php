@extends('adminlte::page')

@section('title', 'Clãs')

@section('content_header')
    <h1>Todos os Clãs</h1>
@stop

{{-- Setup data for datatables PHPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPP--}}
@php
$heads = [
    'Clã',
    'Tag',
    'Líder',
];

$config = [
    'data' => $clans,
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
                        <a href="/clans/{{$row->id}}">
                          <img class="rounded-circle p-1" height="40" width="40" src="/clans-logos/{{$row->logo}}" alt="logo">
                        </a>
                        <a class="text-dark" href="/clans/{{$row->id}}">
                          <span class="fs-6 fw-bold align-middle">{!! $row->name !!}</span>
                        </a>
                    </div>
                </td>
                <td>{!! $row->tag !!}</td>
                <td><a href="/players/{{$leaders[$i]->id}}" class="link-dark">{{$leaders[$i]->nickname}}</a></td>
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
    </style>
    @stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@stop
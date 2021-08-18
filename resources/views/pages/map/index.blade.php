@extends('adminlte::page')

@section('title', 'Clãs')

@section('content_header')
    <div class="d-flex justify-content-between">
        <div class="p-2 bd-highlight">
            <p class="fs-2">Mapas</p>
        </div>
    </div>
@stop

{{-- Setup data for datatables PHPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPP--}}
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
        {{-- Minimal example / fill data using the component slot --}}

    <div class="container">
        <div class="row">
            <div class="col-8 border p-3">
                <form action="{{route('mapnames.destroy')}}" method="post">
                @csrf
                    <x-adminlte-datatable id="table1" :heads="$heads">
                            @foreach ($maps as $map)
                                <tr>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <div>{{$map->name}}</div>
                                            <div><button type="submit" name="mapId" value="{{$map->id}}" class="btn btn-outline-danger btn-sm">Excluir</button></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                    </x-adminlte-datatable>
                </form>
            </div>

            <div class="col-4 d-flex justify-content-center">
                <form action="{{ route('mapnames')}}" method="post">
                    @csrf
                        <div class="row">
                            <x-adminlte-input name="mapname" label="Novo Mapa" placeholder="Mapa..."
                                fgroup-class="col-md-6" disable-feedback/>
                        </div>
            
                    <x-adminlte-button type="submit" label="Adicionar" theme="primary"/>
                </form>
            </div>
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
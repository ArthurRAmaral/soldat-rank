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

$btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </button>';
$btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                  <i class="fa fa-lg fa-fw fa-trash"></i>
              </button>';
$btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                   <i class="fa fa-lg fa-fw fa-eye"></i>
               </button>';


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
                    <td>{!! $row->name !!}</td>
            
        
                <td>{!! $row->tag !!}</td>
            
            
                <td>{!! $leaders[$i]->name!!}</td>
                @php
                    $i++;
                @endphp
            </tr>
        @endforeach
    </x-adminlte-datatable>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
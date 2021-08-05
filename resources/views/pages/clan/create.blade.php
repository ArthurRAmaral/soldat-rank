@extends('adminlte::page')

@section('title', 'Cadastrar Clã')

@section('content_header')
    <h1>Cadastrar Clã</h1>
@stop

@section('content')
    <form action="{{ route('clans')}}" method="post">
        @csrf

            <div class="row">
                <x-adminlte-input name="name" label="Nome do Clã" placeholder="Nome do clã"
                    fgroup-class="col-md-6" disable-feedback/>
            </div>

            @if($errors->has('name'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </div>
            @endif

            <div class="row">
                <x-adminlte-input name="tag" label="Tag do Clã" placeholder="Tag do clã"
                    fgroup-class="col-md-6" disable-feedback/>
            </div>

            @if($errors->has('tag'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('tag') }}</strong>
                </div>
            @endif


        <x-adminlte-button type="submit" label="Criar" theme="primary"/>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
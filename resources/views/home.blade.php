@extends('layouts.app')

@section('content')
    {{--<router-view></router-view>--}}
    <index-principal></index-principal>
@endsection

@section('js')
    <script>
        window.permisos_usuario = @json(\Auth::user()->getAllAbilities());
        console.log("Permisos: ", window.permisos_usuario);
    </script>
@endsection

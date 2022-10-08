@extends('layouts.ogani.master')

@section('title', 'Sportec Tienda | Categorias')

@section('content')
    @include('web.section_header')
    @include('web.section_breadcrumb')
    @include('web.empresas.section_categorias')
    @include('web.section_contacto')
@endsection

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css">--}}
@endsection

@section('js')
    {{--@include('web.funciones_ajax')--}}
    @include('web.funciones_android')
    <script type="text/javascript">console.log('Hi!')</script>
@endsection

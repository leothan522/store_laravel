@extends('layouts.ogani.master')

@section('title', 'Sportec Tienda | Detalles')

@section('content')

    @include('web.section_header')
    @include('web.section_breadcrumb')
    @include('web.detalles.details')
    @if($listarRelacionados->isNotEmpty())
        @include('web.detalles.related')
    @endif
    <a href="@if($ruta == "android") # @else {{ route('web.tienda', $stock->empresas_id) }} @endif">
        @include('web.home.section_banner')
    </a>
    @include('web.section_contacto')


@endsection

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css">--}}
@endsection

@section('js')
    @if(\Illuminate\Support\Facades\Route::currentRouteName() != "guest.detalles")
        @include('web.funciones_ajax')
    @endif
    @include('web.funciones_android')
    <script type="text/javascript">console.log('Hi!')</script>
@endsection

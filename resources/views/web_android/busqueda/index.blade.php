@extends('layouts.multishop.master_android')

@section('title', 'Busqueda')

@section('content')

    <!-- Breadcrumb Start -->
    @include('web_android.busqueda.breadcrumb')
    <!-- Breadcrumb End -->

    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">

        <!-- Shop Product Start -->
        @include('web_android.busqueda.show')
        <!-- Shop Product End -->

        <!-- Shop Sidebar Start -->
        @include('web_android.busqueda.sidebar')
        <!-- Shop Sidebar End -->

        @include('web_up.busqueda.offer')

        </div>
    </div>
    <!-- Shop End -->

@endsection


@section('js')

    @include('web_up.funciones_ajax')
    @include('web_up.funciones_android')

    <script type="text/javascript">
        console.log('Hi!');
    </script>

@endsection

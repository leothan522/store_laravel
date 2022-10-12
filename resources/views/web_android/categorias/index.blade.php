@extends('layouts.multishop.master_android')

@section('title', 'Favoritos')

@section('content')


    <!-- Breadcrumb Start -->
    @include('web_android.categorias.breadcrumb')
    <!-- Breadcrumb End -->

    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
        {{--@include('web_up.favoritos.sidebar')--}}
        <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
        @include('web_android.categorias.show')
        <!-- Shop Product End -->
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

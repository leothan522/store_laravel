@extends('layouts.multishop.master_android')

@section('title', 'Tiendas')

@section('content')


    <!-- Breadcrumb Start -->
    @include('web_android.tiendas.breadcrumb')
    <!-- Breadcrumb End -->

    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">

        <!-- Shop Product Start -->
        @include('web_android.tiendas.show')
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

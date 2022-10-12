@extends('layouts.multishop.master_android')

@section('title', 'Pedidos')

@section('content')


    <!-- Breadcrumb Start -->
        @include('web_android.pedidos.breadcrumb')
    <!-- Breadcrumb End -->

    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
        @include('web_android.pedidos.sidebar')
        <!-- Shop Sidebar End -->


        <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                @include('web_android.pedidos.offer')
            </div>
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

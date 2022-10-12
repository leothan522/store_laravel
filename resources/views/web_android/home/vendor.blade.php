@if($listarVendor->count() > 8)

    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Productos Ramdom</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">

                        @foreach($listarVendor as $stock)
                            <div class="bg-light p-4">
                                <a href="{{ route('android.detalles', [auth()->id(), $stock->id]) }}" onclick="preSubmit()">
                                    <img src="{{ asset(verImg($stock->producto->miniatura)) }}{{--img/vendor-1.jpg--}}" alt="">
                                </a>
                            </div>
                        @endforeach


                    {{--<div class="bg-light p-4">
                        <img src="{{ asset('vendor/multishop/img/vendor-2.jpg') }}--}}{{--img/vendor-2.jpg--}}{{--" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="{{ asset('vendor/multishop/img/vendor-3.jpg') }}--}}{{--img/vendor-3.jpg--}}{{--" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="{{ asset('vendor/multishop/img/vendor-4.jpg') }}--}}{{--img/vendor-4.jpg--}}{{--" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="{{ asset('vendor/multishop/img/vendor-5.jpg') }}--}}{{--img/vendor-5.jpg--}}{{--" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="{{ asset('vendor/multishop/img/vendor-6.jpg') }}--}}{{--img/vendor-6.jpg--}}{{--" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="{{ asset('vendor/multishop/img/vendor-7.jpg') }}--}}{{--img/vendor-7.jpg--}}{{--" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="{{ asset('vendor/multishop/img/vendor-8.jpg') }}--}}{{--img/vendor-8.jpg--}}{{--" alt="">
                    </div>--}}
                </div>
            </div>
        </div>
    </div>
@endif

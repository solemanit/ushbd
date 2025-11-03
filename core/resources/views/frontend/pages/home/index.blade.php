@extends('frontend.layouts.master')

@section('title', 'Universal Service Hub BD')

@section('content')

    {{-- @include('frontend.pages.home.sections.hero') --}}

    <div class="page-content">
        @include('frontend.pages.home.sections.slider')

        <section class="py-5">
            <div class="container">
                <div class="row row-cols-1 row-cols-lg-3 g-4">
                    <div class="col">
                        <div class="p-3 border d-flex align-items-center justify-content-center">
                            <div class="fs-1 text-content"><i class="bx bx-taxi"></i>
                            </div>
                            <div class="info-box-content ps-3">
                                <h6 class="mb-0 fw-bold">FAST DELIVERY</h6>
                                <p class="mb-0">Get fast and hassle-free delivery</p>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="p-3 border d-flex align-items-center justify-content-center">
                            <div class="fs-1 text-content"><i class="bx bx-dollar-circle"></i>
                            </div>
                            <div class="info-box-content ps-3">
                                <h6 class="mb-0 fw-bold">MONEY BACK GUARANTEE</h6>
                                <p class="mb-0">100% money back guarantee</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-3 border d-flex align-items-center justify-content-center">
                            <div class="fs-1 text-content"><i class="bx bx-support"></i>
                            </div>
                            <div class="info-box-content ps-3">
                                <h6 class="mb-0 fw-bold">ONLINE SUPPORT 24/7</h6>
                                <p class="mb-0">Awesome Support for 24/7 Days</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </section>

        @include('frontend.pages.home.sections.categories')

        @include('frontend.pages.home.sections.cards')
    </div>
@endsection

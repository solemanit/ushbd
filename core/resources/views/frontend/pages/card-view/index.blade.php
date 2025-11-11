@extends('frontend.layouts.master')

@section('title', 'USHBD')

@section('content')
    <div class="page-content">
        <section class="py-3 border-bottom border-top d-none d-md-flex bg-light">
            <div class="container">
                <div class="page-breadcrumb d-flex align-items-center">
                    <h3 class="breadcrumb-title pe-3">Card Deatils</h3>
                    <div class="ms-auto">
                        <nav aria-label="breadcrumb">
                            <ol class="p-0 mb-0 breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i> Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!--start product details-->
        <section class="py-4 pt-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-12 col-xl-7">
                        <img src="{{ asset('storage/' . $product->image) }}" class="rounded img-fluid">
                    </div>
                    <div class="col-12 col-xl-5">
                        <div class="product-info">
                            <h4 class="mb-1 product-title fw-bold">{{ $product->name }}</h4>
                            <p class="mb-0">
                                <strong>Service:</strong> {{ $product->service ? $product->service->title : 'No Service' }}
                                |
                                <strong>Brand:</strong> {{ $product->brand ? $product->brand->name : 'No Brand' }} |
                                <strong>Discount:</strong> {{ $product->discount . '%' ?? 'No Discount' }}
                                <hr>
                            <div class="mt-3 cart-buttons">
                                <div class="gap-3 mt-4 buttons d-flex flex-column flex-lg-row">

                                    {{-- WhatsApp Order --}}
                                    <a href="https://wa.me/15551234567"
                                        target="_blank"
                                        class="px-5 py-3 btn btn-lg btn-success btn-ecomm col-lg-6 whatsapp-btn">
                                        <i class="bi bi-whatsapp me-2"></i>Order via WhatsApp
                                    </a>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="product-info">
                    <h5 class="mt-4 mb-3 fw-bold">Discount Card Details</h5>
                    {!! $product->description !!}
                </div><!--end row-->
            </div>
        </section>
        <!--start product details-->
        <!--end product details-->
    </div>
@endsection

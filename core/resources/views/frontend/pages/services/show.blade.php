@extends('frontend.layouts.master')

@section('title', $service->title)

@section('content')
<div class="page-content">
    <section class="py-5">
        <div class="container">

            <div class="pb-4 text-center">
                <h3 class="mb-0 h3 fw-bold">{{ $service->title }}</h3>
                <p class="mb-0 text-capitalize">Select your favorite discount card and purchase</p>
            </div>

            <div class="product-grid tab-content tabular-product">
                <div id="productList" class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-5 g-3 g-sm-4">

                    @php $products = $products ?? collect(); @endphp

                    @if($products->count() > 0)
                        @foreach($products as $product)
                            <div class="col">
                                <div class="card">
                                    <div class="p-2 overflow-hidden position-relative">
                                        <a href="{{ route('card.view', $product->slug) }}">
                                            <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid" alt="{{ $product->name }}">
                                        </a>
                                    </div>

                                    <div class="px-0" style="background: #f9f9f9;padding: 10px;padding-bottom: 0;">
                                        <div style="margin-left: 20px;">
                                            <p class="mb-1 product-short-name">
                                                {{ $product->brand->name ?? '' }} | {{ $product->service->title ?? '' }}
                                            </p>

                                            <h6 class="mb-2 fw-bold product-short-title">{{ $product->name }}</h6>

                                            <div class="h6 fw-bold text-danger">
                                                ({{ $product->discount ?? 0 }}% off)
                                            </div>
                                        </div>

                                        <a href="{{ route('card.view', $product->slug) }}" class="mt-3 btn btn-dark btn-ecomm">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="p-4 text-center">No Product Found</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

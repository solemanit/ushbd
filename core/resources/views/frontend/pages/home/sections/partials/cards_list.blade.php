@php $products = $products ?? collect(); @endphp

@if($products->count() > 0)
    @foreach($products as $product)
        <div class="col">
            <div class="card">
                <div class="p-2 overflow-hidden position-relative">
                    <a href="{{ route('card.view', $product->slug) }}">
                        <img src='{{ asset('storage/'.$product->image) }}' class="img-fluid" alt="{{ $product->name }}">
                    </a>
                </div>
                <div class="px-0" style="background: #f9f9f9;padding: 10px;padding-bottom: 0;">
                    <div style="margin-left: 20px;">
                        <p class="mb-1 product-short-name">{{ $product->category->name ?? '' }}</p>
                        <h6 class="mb-0 fw-bold product-short-title">{{ $product->name }}</h6>
                    </div>
                    <div class="gap-2 mt-2 mb-2 product-price d-flex align-items-center justify-content-start" style="margin-left: 20px;">
                        @if($product->discount > 0)
                            <div class="h6 fw-light text-secondary text-decoration-line-through">৳{{ $product->price }}</div>
                            <div class="h6 fw-bold">৳{{ $product->price - $product->discount }}</div>
                        @else
                            <div class="h6 fw-bold">৳{{ $product->price }}</div>
                        @endif
                    </div>
                    <a href="{{ route('card.view', $product->slug) }}" class="btn btn-dark btn-ecomm">Buy</a>
                </div>
            </div>
        </div>
    @endforeach
@else
    <p class="p-4 text-center">No Product Found</p>
@endif

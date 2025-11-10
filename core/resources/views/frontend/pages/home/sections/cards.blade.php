@php $products = $products ?? collect(); @endphp

<section class="py-5">
    <div class="container">
        {{-- Page Title --}}
        <div class="pb-4 text-center">
            <h3 class="mb-0 h3 fw-bold">Discount Cards</h3>
            <p class="mb-0 text-capitalize">Select your favorite discount card and purchase</p>
        </div>

        {{-- Filters --}}
        <div class="mb-3 card rounded-0">
            <div class="card-body">
                <div class="row g-3">
                    {{-- Service --}}
                    <div class="col-12 col-lg-3">
                        <div class="form-floating">
                            <select class="form-select form-select-lg rounded-0" id="service_id">
                                <option value="">Select</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->title }}</option>
                                @endforeach
                            </select>
                            <label for="service_id">Service</label>
                        </div>
                    </div>

                    {{-- Brand --}}
                    <div class="col-12 col-lg-3">
                        <div class="form-floating">
                            <select class="form-select form-select-lg rounded-0" id="brand_id">
                                <option value="">Select</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            <label for="brand_id">Brand</label>
                        </div>
                    </div>

                    {{-- Division --}}
                    <div class="col-12 col-lg-3">
                        <div class="form-floating">
                            <select class="form-select form-select-lg rounded-0" id="division_id" disabled>
                                <option value="">Select</option>
                            </select>
                            <label for="division_id">Division</label>
                        </div>
                    </div>

                    {{-- District --}}
                    <div class="col-12 col-lg-3">
                        <div class="form-floating">
                            <select class="form-select form-select-lg rounded-0" id="district_id" disabled>
                                <option value="">Select</option>
                            </select>
                            <label for="district_id">District</label>
                        </div>
                    </div>

                    {{-- Search Button --}}
                    <div class="col-12">
                        <button type="button" id="searchBtn" class="px-5 py-3 mb-3 btn btn-ecomm btn-dark w-100">
                            Search
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Products --}}
        <div class="product-grid tab-content tabular-product">
            <div id="productList"
                class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-5 g-3 g-sm-4">
                @include('frontend.pages.home.sections.partials.cards_list', ['products' => $products])
            </div>
        </div>
    </div>
</section>

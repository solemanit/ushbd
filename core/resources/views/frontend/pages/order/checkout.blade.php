@extends('frontend.layouts.master')

@section('title', 'Checkout')

@section('content')
    <div class="page-content">
        <section class="section-padding">
            <div class="container">
                <div class="px-3 py-2 mb-4 border d-flex align-items-center">
                    <div class="text-start">
                        <h4 class="mb-0 h4 fw-bold">Order Details</h4>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Checkout Form -->
                    <div class="col-12 col-lg-8 col-xl-8">
                        <form action="{{ route('checkout.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <!-- Personal Details -->
                            <h6 class="px-3 py-2 mb-3 fw-bold bg-light">Personal Details</h6>
                            <div class="mb-3 card rounded-0">
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12 col-lg-6">
                                            <div class="form-floating">
                                                <input type="text" name="full_name" class="form-control rounded-0"
                                                    id="floatingFirstName" placeholder="Full Name" required>
                                                <label for="floatingFirstName">Full Name</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-floating">
                                                <input type="email" name="email" class="form-control rounded-0"
                                                    id="floatingEmail" placeholder="Email">
                                                <label for="floatingEmail">Email</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-floating">
                                                <input type="text" name="phone" class="form-control rounded-0"
                                                    id="floatingMobileNo" placeholder="Mobile No" required>
                                                <label for="floatingMobileNo">Mobile No</label>
                                            </div>
                                        </div>
                                    </div><!--end row-->
                                </div>
                            </div>

                            <!-- Shipping Details -->
                            <h6 class="px-3 py-2 mb-3 fw-bold bg-light">Shipping Details</h6>
                            <div class="card rounded-0">
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12 col-lg-12">
                                            <div class="form-floating">
                                                <textarea name="address" class="form-control rounded-0" id="floatingStreetAddress" placeholder="Full Address"
                                                    rows="3" required></textarea>
                                                <label for="floatingStreetAddress">Full Address</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="form-floating">
                                                <select name="division_id" class="form-select rounded-0" id="division_id">
                                                    <option value="">Select Division</option>
                                                </select>
                                                <label for="division_id">Division</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="form-floating">
                                                <select name="district_id" class="form-select rounded-0" id="district_id"
                                                    disabled>
                                                    <option value="">Select District</option>
                                                </select>
                                                <label for="district_id">District</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="form-floating">
                                                <input type="text" name="zip_code" class="form-control rounded-0"
                                                    id="floatingZipCode" placeholder="Zip Code">
                                                <label for="floatingZipCode">Zip Code</label>
                                            </div>
                                        </div>
                                    </div><!--end row-->
                                </div>
                            </div>

                            <!-- Submit Button for form -->
                            <div class="mt-4 d-grid">
                                <button type="submit" class="px-5 py-3 btn btn-dark btn-ecomm">Confirm Order</button>
                            </div>
                        </form>
                    </div>
                </div><!--end row-->
            </div>
        </section>
    </div>
@endsection

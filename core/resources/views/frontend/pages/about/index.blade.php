@extends('frontend.layouts.master')

@section('title', 'Universal Service Hub BD')

@section('content')
    <div class="page-content">
        <section class="py-3 border-bottom border-top d-none d-md-flex bg-light">
            <div class="container">
                <div class="page-breadcrumb d-flex align-items-center">
                    <h3 class="breadcrumb-title pe-3">About Us</h3>
                    <div class="ms-auto">
                        <nav aria-label="breadcrumb">
                            <ol class="p-0 mb-0 breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i> Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">About Us</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-padding">
            <div class="container">
                <div class="row g-4">
                    <div class="col-12 col-xl-6">
                        <h3 class="fw-bold">Our Story</h3>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                            the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
                            of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                            but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                            classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a
                            Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure.</p>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                            classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a
                            Latin professor at Hampden-Sydney College.</p>
                    </div>
                    <div class="col-12 col-xl-6">
                        <img src="{{ asset('images/demo-v1.jpg') }}" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="mt-5 row g-4">
                    <div class="col-12 col-xl-6">
                        <img src="{{ asset('images/demo-v2.jpg') }}" class="img-fluid" alt="">
                    </div>
                    <div class="col-12 col-xl-6">
                        <h3 class="fw-bold">Our Story</h3>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                            the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
                            of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                            but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                            classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a
                            Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure.</p>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                            classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a
                            Latin professor at Hampden-Sydney College.</p>
                    </div>
                </div><!--end row-->
            </div>
        </section>
    </div>
@endsection

@extends('frontend.layouts.master')

@section('title', 'Universal Service Hub BD')

@section('content')
    <div class="page-content">
        <section class="py-3 border-bottom border-top d-none d-md-flex bg-light">
            <div class="container">
                <div class="page-breadcrumb d-flex align-items-center">
                    <h3 class="breadcrumb-title pe-3">Contact Us</h3>
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
        <section class="section-padding">
            <div class="container">
                <!-- Success Message -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Error Message -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row g-4">
                    <div class="col-xl-12">
                        <div class="p-3 border">

                            <div class="mb-3 address">
                                <h5 class="mb-0 fw-bold">Address</h5>
                                <p class="mb-0 font-12">
                                    {{ $contact->address ?? 'No address provided yet.' }}
                                </p>
                            </div>

                            <hr>

                            <div class="mb-3 phone">
                                <h5 class="mb-0 fw-bold">Phone</h5>
                                <p class="mb-0 font-13">
                                    {{ $contact->phone ?? 'Not provided' }}
                                </p>
                            </div>

                            <hr>

                            <div class="mb-3 email">
                                <h5 class="mb-0 fw-bold">Email</h5>
                                <p class="mb-0 font-13">
                                    {{ $contact->email ?? 'Not provided' }}
                                </p>
                            </div>

                            <hr>

                            <div class="mb-0 working-days">
                                <h5 class="mb-0 fw-bold">Working Days</h5>
                                <p class="mb-0 font-13">
                                    {{ $contact->working_days ?? 'Not provided' }}
                                </p>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection

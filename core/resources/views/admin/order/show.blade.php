@extends('admin.layouts.master')

@section('title', 'Order Details | Admin Panel')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Order #{{ $order->id }}
                </h2>
                <p class="text-muted">Details of the placed order</p>
            </div>
            <div class="col-auto ms-auto">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                    Back to Orders
                </a>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="mb-3 card">
                    <div class="card-body">
                        <h5 class="mb-3 fw-bold">Customer Details</h5>
                        <div class="row">
                            <div class="col-6">
                                <p><strong>Full Name:</strong> {{ $order->full_name }}</p>
                                <p><strong>Email:</strong> {{ $order->email ?? 'N/A' }}</p>
                                <p><strong>Phone:</strong> {{ $order->phone }}</p>
                            </div>
                            <div class="col-6">
                                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                                <p><strong>Ordered Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3 card">
                    <div class="card-body">
                        <h5 class="mb-3 fw-bold">Shipping Address</h5>
                        <p>{{ $order->address }}</p>
                    </div>
                </div>

                <div class="mb-3 card">
                    <div class="card-body">
                        <h5 class="mb-3 fw-bold">Product Details</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $order->product->name ?? 'N/A' }}</td>
                                    <td>৳{{ number_format($order->price, 2) }}</td>
                                    <td>{{ $order->quantity }}</td>
                                    <td>৳{{ number_format($order->total, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

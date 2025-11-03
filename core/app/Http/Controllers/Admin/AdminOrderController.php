<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class AdminOrderController extends Controller
{
    // Show all orders
    public function index()
    {
        // Eager load product relation and paginate 10 per page
        $orders = Order::with('product')->latest()->get();

        return view('admin.order.index', compact('orders'));
    }

    // Show single order details
    public function show(Order $order)
    {
        $order->load('product'); // eager load product relation
        return view('admin.order.show', compact('order'));
    }
}

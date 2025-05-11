<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        return view('order.index');
    }

    public function updateStatus(Request $request)
    {
        $order = Order::find($request->order_id);

        if ($order) {
            $order->status = $request->status;
            $order->save();
            return redirect()->back()->with('success', 'Order status updated.');
        }

        return redirect()->back()->with('error', 'Order not found.');
    }

    public function sendNotification(Request $request)
    {
        $order = Order::find($request->order_id);

        if ($order) {
            // Simulate sending a notification (you can replace this with actual logic)
            return redirect()->back()->with('success', 'Notification sent for Order #' . $order->id);
        }

        return redirect()->back()->with('error', 'Order not found.');
    }

    public function refund(Request $request)
    {
        $order = Order::find($request->order_id);

        if ($order) {
        // Simulate refund by changing order status
        $order->status = 'refunded'; // or whatever status fits your app
        $order->save();

        return redirect()->back()->with('success', 'Order has been refunded.');
    }

    return redirect()->back()->with('error', 'Order not found.');
}
}

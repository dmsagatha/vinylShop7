<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use Json;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistoryController extends Controller
{
  // Show the full order history
  public function index ()
  {
    $orders = Order::where('user_id', auth()->id())
        ->with('orderlines')
        ->orderBy('created_at', 'desc')
        ->get();
    $result = compact('orders');
    Json::dump($result);
    
    return view('user.history', $result);
  }
  
  // Add data from cart to the database
  public function checkout()
  {
    // Create a new order and save it to the orders table
    $order = new Order();
    $order->user_id = auth()->id();
    $order->total_price = Cart::getTotalPrice();
    $order->save();

    // Retrieve the id of the last inserted order
    $order_id = $order->id;

    // Loop over the records array in the cart and save them to the orderlines table
    foreach (Cart::getRecords() as $record) {
        $orderline = new Orderline();
        $orderline->order_id = $order_id;
        $orderline->artist = $record['artist'];
        $orderline->title = $record['title'];
        $orderline->cover = $record['cover'];
        $orderline->total_price = $record['price'];
        $orderline->quantity = $record['qty'];
        $orderline->save();
    }

    // Empty the cart 
    Cart::empty();

    // Redirect to the history page
    $message = 'Thank you for your order.<br>The records will be delivered as soon as possible.';

    session()->flash('success', $message);

    return redirect('/user/history');
  }
}
<?php

namespace App\Http\Controllers\User;

use App\Models\{Order, Orderline};
use Json;
use Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistoryController extends Controller
{
  // Mostrar el historial de pedidos completo
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
  
  // Agregar datos del carro de compras a la base de datos
  public function checkout()
  {
    // Crear un nuevo pedido y guárdarlo en la tabla de pedidos
    $order = new Order();
    $order->user_id = auth()->id();
    $order->total_price = Cart::getTotalPrice();
    $order->save();

    // Recuperar la identificación del último pedido insertado
    $order_id = $order->id;

    // Recorrer la matriz de registros en el carro de compras y guardarlo en la
    // tabla de líneas de pedido
    foreach (Cart::getRecords() as $record) {
        $orderline = new Orderline();
        $orderline->order_id = $order_id;
        $orderline->artist   = $record['artist'];
        $orderline->title    = $record['title'];
        $orderline->cover    = $record['cover'];
        $orderline->total_price = $record['price'];
        $orderline->quantity    = $record['qty'];
        $orderline->save();
    }
    
    // Vaciar el carro de compras
    Cart::empty();

    // Redireccionar a la página del historial de compras
    $message = 'Gracias por su pedido.<br>Su pedido se entregará lo antes posible.';

    session()->flash('success', $message);

    return redirect('/user/history');
  }
}
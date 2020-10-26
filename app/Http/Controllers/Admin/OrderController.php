<?php

namespace App\Http\Controllers\Admin;

use Json;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
  // Mostrar el historial de pedidos completo
  public function index ()
  {
    /* $orders = Order::with(['orderlines', 'user'])
                  ->orderByDesc('id')
                  ->get(); */
    // Definir que columnas se van a incluir, siempre incluir el id
    $orders = Order::with(['orderlines:id,order_id,artist,title,cover,total_price,quantity', 'user:id,name,email'])
          ->select(['id','user_id','total_price','created_at'])
          ->orderByDesc('id')
          ->get();
    $result = compact('orders');
    // http://localhost:3000/admin/orders?json
    Json::dump($result);

    return view('admin.orders.index', $result);
  }
}
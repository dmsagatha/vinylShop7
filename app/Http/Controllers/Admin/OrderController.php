<?php

namespace App\Http\Controllers\Admin;

use Json;
use App\Models\{Order, Orderline, User};
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

  //
  /**
   * Orderlines con order y user
   * Recuperar toda la información de los pedidos con su línea de pedido 
   * y el usuario al que pertenece este pedido
   * Incluir todas las claves externas primarias y relevantes
   */
  public function orderlines()
  {
    //$orderlines = Orderline::with('order.user')->get();
    //$orderlines = Orderline::with(['order', 'order.user'])->get();
    $orderlines = Orderline::with(['order:id,user_id,total_price', 'order.user:id,name,email'])->get();

    return $orderlines;
  }
  
  /**
   * User con orders y orderlines
   * Recuperar toda la información de los pedidios del usuarios y los línea de
   * pedidos
   */
  public function users()
  {
    //$users = User::with('orders.orderlines')->get();
    //$users = User::with(['orders','orders.orderlines'])->get();
    // $users = User::with(['orders:id,user_id,total_price', 'orders.orderlines:id,order_id,artist,title'])->get();

    // Agregar condiciones de consulta adicionales
    // Ordenar las líneas de orden (los registros que ordenó un usuario) por artista
    $users = User::with(['orders' => function ($query) {
      // Seleccionar los campos requeridos de la tabla orders
      $query->select(['id', 'user_id', 'total_price'])
          // Ir a la siguiente tabla (orderlines)
          ->with(['orderlines' => function ($query) {
              //  Seleccionar los campos requeridos de la tabla orderlines y ordenar por por artista
              $query->select(['id', 'order_id', 'artist', 'title'])
                  ->orderBy('artist');
          }]);
    }])->get();

    return $users;
  }
}
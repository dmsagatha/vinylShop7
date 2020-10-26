<?php

namespace App\Http\Controllers\User;

use Auth;
use Cart;
use Json;
use Mail;
use App\Models\User;
use App\Mail\OrderMail;
use Illuminate\Http\Request;
use Twilio\TwiML\Voice\Client;
use App\Models\{Order, Orderline};
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
    
    // Enviar mensaje de confirmación
    $this->confirmEmail();

    // Enviar mensaje de confirmación po WhatsApp
    // $this->confirmWhatsApp();

    session()->flash('success', $message);

    return redirect('/user/history');
  }

  private function confirmEmail()
  {
    // Crear el mensaje de correo
    $message = '<p>Gracias por su pediro.<br>Los discos (canciones) se entregarán lo antes posible.</p>';
    $message .= '<ul>';

    foreach (Cart::getRecords() as $record) {
        $message .= "<li>{$record['qty']} x {$record['artist']} - {$record['title']}</li>";
    }
    $message .= '</ul>';

    // Obtener todos los administradores
    $admins = User::whereAdmin(true)->select('name', 'email')->get();

    $email = new OrderMail($message);
    
    Mail::to(Auth::user())
        ->cc($admins)
        ->send($email);
  }
  
  /* private function confirmWhatsApp()
  {
    // get credentials from the .env file
    $id    = env('TWILIO_AUTH_SID');
    $token = env('TWILIO_AUTH_TOKEN');
    $to    = env('TWILIO_WHATSAPP_TO');
    $from  = env('TWILIO_WHATSAPP_FROM');

    // the message for the fourth placeholder of the WhatsApp order template
    $details = "*" . Auth::user()->name . "* has ordered:";
    foreach (Cart::getRecords() as $record) {
        $details .= " {$record['qty']} x {$record['artist']} - {$record['title']},";
    }

    // construct the order template for the sandbox:
    // Your {{1}} order of {{2}} has shipped and should be delivered on {{3}}. Details: {{4}}
    $message = "Su pedido *Vinyl Shop* de *today* ha enviado y debe ser entregado en *your address*. Detalles: $details";

    // send WhatsApp message to your phone
    $whatsApp = new Client($sid, $token);
    $whatsApp->messages->create(
        "whatsapp:$to", [
            'from' => "whatsapp:$from",
            'body' => $message
        ]
    );
  } */
}
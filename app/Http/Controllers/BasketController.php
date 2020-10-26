<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Json;
use Cart;
use Illuminate\Http\Request;

class BasketController extends Controller
{
  public function index()
  {
    // Tomar los primeros 3 registros, ordenados por título de álbum
    $records = Record::orderBy('title')->take(3)->get();
    $result  = compact('records');
    Json::dump($result);
    
    return view('basket', $result);
  }

  public function addToCart($id)
  {
    $record = Record::findOrFail($id);
    Cart::add($record);
    return back();
  }

  public function deleteFromCart($id)
  {
    $record = Record::findOrFail($id);
    Cart::delete($record);
    return back();
  }

  public function emptyCart()
  {
    Cart::empty();
    return redirect('basket');
  }
}
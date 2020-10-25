<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Facades\App\Helpers\Cart;
use Json;
use Illuminate\Http\Request;

class BasketController extends Controller
{
  public function index()
  {
    // Take the first 3 records, ordered by album title
    $records = Record::orderBy('title')->take(3)->get();
    $result  = compact('records');
    Json::dump($result);

    return view('basket', $result);
  }

  public function addToCart($id)
  {
    $record = Record::findOrFail($id);
    $record->cover = $record->cover ?? "https://coverartarchive.org/release/$record->title_mbid/front-250.jpg";
    Cart::add($record);

    session()->flash('success', "La canción <b>$record->title</b> de <b>$record->artist</b> fue adicionada al carro de compras.");

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
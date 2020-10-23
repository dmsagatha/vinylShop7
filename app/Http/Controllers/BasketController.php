<?php

namespace App\Http\Controllers;

use Cart;
use Json;
use App\Models\Record;
use Illuminate\Http\Request;

class BasketController extends Controller
{
  public function index()
  {
    // Toma los primeros 3 registros, ordenados por título de álbum.
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

    session()->flash('success', "La canción <b>$record->title</b> de <b>$record->artist</b> fue adicionada en la canasta!");

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
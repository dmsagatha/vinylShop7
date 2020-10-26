<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\Record;
use Json;
use Cart;
=======
use Cart;
use Json;
use App\Models\Record;
>>>>>>> master
use Illuminate\Http\Request;

class BasketController extends Controller
{
  public function index()
  {
<<<<<<< HEAD
    // Tomar los primeros 3 registros, ordenados por título de álbum
=======
    // Toma los primeros 3 registros, ordenados por título de álbum.
>>>>>>> master
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

<<<<<<< HEAD
    session()->flash('success', "The record <b>$record->title</b> from <b>$record->artist</b> has been added to your basket");
    
=======
    session()->flash('success', "La canción <b>$record->title</b> de <b>$record->artist</b> fue adicionada en la canasta!");

>>>>>>> master
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
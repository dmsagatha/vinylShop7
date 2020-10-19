<?php

namespace App\Http\Controllers\Admin;

use App\Models\Record;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Genre;
use Json;

class ShopController extends Controller
{
  // Master Page: http://vinyl_shop.test/shop or http://localhost:3000/shop
  public function index()
  {
    $records = Record::with('genre')->paginate(3);   // get all records
    //dd($records);               // 'dump' the collection and 'die' (stop execution)

    foreach ($records as $record) {
      $record->cover = $record->cover ?? "https://coverartarchive.org/release/$record->title_mbid/front-250.jpg";
    }

    $genres = Genre::orderBy('name')
          ->has('records')        // Recuperar solo aquellos géneros que tienen registros
          ->withCount('records')  // Agregar una nueva propiedad records_count a los modelos de género
          ->get()
          ->transform(function ($item, $key) {
              // Establecer la primera letra del nombre en mayúsculas y agregar el contador
              $item->name = ucfirst($item->name) . ' (' . $item->records_count . ')';
              // Eliminar todos los campos que no usa dentro de la vista
              unset($item->created_at, $item->updated_at, $item->records_count);
              return $item;
          });

    // compact('records') is the same as ['records' => $records]
    // $result = ['genres' => $genres, 'records' => $records]
    $result = compact('genres', 'records'); 
    Json::dump($result);                    // http://vinyl_shop.test/shop?json

    return view('admin.shop.index', $result);     // http://localhost:3000/shop?json
  }

  // Detail Page: http://vinyl_shop.test/shop/{id} or http://localhost:3000/shop/{id}
  public function show($id)
  {
    return view('admin.shop.show', ['id' => $id]);  // Send $id to the view
  }
}
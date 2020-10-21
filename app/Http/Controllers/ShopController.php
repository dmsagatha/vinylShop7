<?php

namespace App\Http\Controllers;

use Json;
use App\Models\Genre;
use App\Models\Record;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ShopController extends Controller
{
  // Master Page: http://vinyl_shop.test/shop or http://localhost:3000/shop
  public function index(Request $request)
  {
    // Obtener los valores del campo de texto artist y la lista desplegable genre_id
    $genre_id = $request->input('genre_id') ?? '%'; //OR $genre_id = $request->genre_id ?? '%';
    $artist_title = '%' . $request->input('artist') . '%'; // OR $artist_title = '%' . $request->artist . '%';

    // "Preparar" los valores resultantes antes de usarlos en la consulta
    // Filtrar la colección
    // Agregar (appends) los parámetros de solicitud a los enlaces de paginación
    $records = Record::with('genre')
          // Busqueda básica
          /* ->where('artist', 'like', $artist_title)
          ->where('genre_id', 'like', $genre_id) */
          // Busqueda avanzada
          ->where(function ($query) use ($artist_title, $genre_id) {
              $query->where('artist', 'like', $artist_title)
                    ->where('genre_id', 'like', $genre_id);
          })
          ->orWhere(function ($query) use ($artist_title, $genre_id) {
              $query->where('title', 'like', $artist_title)
                    ->where('genre_id', 'like', $genre_id);
          })
          ->paginate(3)
          ->appends(['artist'=> $request->input('artist'), 'genre_id' => $request->input('genre_id')]);
          // OR ->appends(['artist' => $request->artist, 'genre_id' => $request->genre_id]);

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

    //dd($records);               // 'dump' the collection and 'die' (stop execution)
    // compact('records') is the same as ['records' => $records]
    // $result = ['genres' => $genres, 'records' => $records]
    $result = compact('genres', 'records'); 
    Json::dump($result);                    // http://vinyl_shop.test/shop?json

    return view('shop.index', $result);     // http://localhost:3000/shop?json
  }

  // Detail Page: http://vinyl_shop.test/shop/{id} or http://localhost:3000/shop/{id}
  public function show($id)
  {
    $record = Record::with('genre')->findOrFail($id);
    //dd($record);
    // Path real ára la imagen de la portada
    $record->cover = $record->cover ?? "https://coverartarchive.org/release/$record->title_mbid/front-250.jpg";
    // Combinar artist + title
    $record->title = $record->artist . ' - ' . $record->title;
    // Links to MusicBrainz API (used by jQuery)
    // https://wiki.musicbrainz.org/Development/JSON_Web_Service
    $record->recordUrl = 'https://musicbrainz.org/ws/2/release/' . $record->title_mbid . '?inc=recordings+url-rels&fmt=json';
    // Si stock> 0: el botón es verde, de lo contrario el botón es rojo
    $record->btnClass = $record->stock > 0 ? 'btn-outline-success' : 'btn-outline-danger';
    // No puede sobrescribir el atributo genre (object) con una cadena, por lo que creamos un nuevo atributo
    $record->genreName = $record->genre->name;
    // Remover todos los campos que no esta usando en la vista
    unset($record->genre_id, $record->artist, $record->created_at, $record->updated_at, $record->title_mbid, $record->genre);

    // Obtener información del Record y convertirla en Json
    $response = Http::get($record->recordUrl)->json();
    $tracks   = $response['media'][0]['tracks'];
    $tracks = collect($tracks)
        ->transform(function ($item, $key) {
            $item['length'] = gmdate('i:s', $item['length']/1000);  // PHP works with sec, not ms!!!
            unset($item['id'], $item['recording'], $item['number']);
            return $item;
        });

    $result = compact('tracks', 'record');
    Json::dump($result);          // http://localhost:3000/shop/1?json

    return view('shop.show', $result);  // Pass $result to the view
  }
}
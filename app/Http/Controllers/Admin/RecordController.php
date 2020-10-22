<?php

namespace App\Http\Controllers\Admin;

use App\Models\Genre;
use App\Models\Record;
use Json;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecordController extends Controller
{
  public function index()
  {
    return redirect('admin/records/create');
  }
  
  public function create()
  {
    // Necesitamos una lista de géneros dentro del formulario
    $genres = Genre::select(['id', 'name'])->orderBy('name')->get();

    // Para evitar errores con los 'valores antiguos' dentro del formulario,
    // tenemos que enviar un objeto Record vacío a la vista
    $record = new Record();
    $result = compact('genres', 'record');
    Json::dump($result);

    return view('admin.records.create', $result);
  }
  
  public function store(Request $request)
  {
    $this->validate($request, [
      'artist' => 'required',
      'title' => 'required',
      'title_mbid' => 'required|size:36|unique:records,title_mbid',
      'genre_id' => 'required',
      'price' => 'required|numeric',
      'stock' => 'required|integer',
    ], [
      'title_mbid.required' => 'El título MusicBrainz ID es requerido.',
      'title_mbid.size' => 'El título MusicBrainz ID debe ser de :size carateres.',
      'title_mbid.unique' => 'Este disco ya existe!',
      'genre_id.required' => 'Por favor seleccionar un género.',
    ]);

    $record = new Record();
    $record->artist = $request->artist;
    $record->title = $request->title;
    $record->title_mbid = $request->title_mbid;
    $record->cover = $request->cover;
    $record->price = $request->price;
    $record->stock = $request->stock;
    $record->genre_id = $request->genre_id;
    $record->save();

    // Ir a la página de detalles públicos del registro recién creado
    session()->flash('success', "La canción <b>$record->title</b> de <b>$record->artist</b> fue creado!");
    
    return redirect("/shop/$record->id");
  }
  
  public function show(Record $record)
  {
    return redirect("shop/$record->id");
  }
  
  public function edit(Record $record)
  {
    $genres = Genre::select(['id', 'name'])->orderBy('name')->get();
    $result = compact('genres', 'record');
    Json::dump($result);

    return view('admin.records.edit', $result);
  }
  
  public function update(Request $request, Record $record)
  {
    $this->validate($request, [
      'artist' => 'required',
      'title' => 'required',
      'title_mbid' => 'required|size:36|unique:records,title_mbid,' . $record->id,
      'genre_id' => 'required',
      'price' => 'required|numeric',
      'stock' => 'required|integer',
    ], [
      'title_mbid.required' => 'El título MusicBrainz ID es requerido.',
      'title_mbid.size' => 'El título MusicBrainz ID debe ser de :size carateres.',
      'title_mbid.unique' => 'Este disco ya existe!',
      'genre_id.required' => 'Por favor seleccionar un género.',
    ]);

    $record->genre_id = $request->genre_id;
    $record->artist = $request->artist;
    $record->title = $request->title;
    $record->title_mbid = $request->title_mbid;
    $record->cover = $request->cover;
    $record->price = $request->price;
    $record->stock = $request->stock;
    $record->save();

    // Ir a la página de detalles públicos del registro actualizado
    session()->flash('success', "La canción <b>$record->title</b> de <b>$record->artist</b> fue actualizado°");

    return redirect("/shop/$record->id");
  }
  
  public function destroy(Record $record)
  {
    $record->delete();

    return response()->json([
        'type' => 'success',
        'text' => "La canció fue eliminada!"
    ]);
  }
}
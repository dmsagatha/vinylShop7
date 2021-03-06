<?php

namespace App\Http\Controllers\Admin;

use App\Models\Genre;
use Json;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GenreController extends Controller
{
  public function index()
  {
    return view('admin.genres.index');
  }
  
  public function create()
  {
    return redirect('admin/genres');
  }
  
  public function store(Request $request)
  {
    $this->validate($request,[
        'name' => 'required|min:3|unique:genres,name'
    ]);
    
    $genre = new Genre();
    $genre->name = $request->name;
    $genre->save();

    return response()->json([
      'type' => 'success',
      'text' => "El género musical <b>$genre->name</b> fue creado!"
    ]);
  }
  
  public function show(Genre $genre)
  {
    return redirect('admin/genres');
  }
  
  public function edit(Genre $genre)
  {
    return redirect('admin/genres');
  }
  
  public function update(Request $request, Genre $genre)
  {
    $this->validate($request,[
        'name' => 'required|min:3|unique:genres,name,' . $genre->id
    ]);

    $genre->name = $request->name;
    $genre->save();

    return response()->json([
        'type' => 'success',
        'text' => "El género musical <b>$genre->name</b> fue actualizado!"
    ]);
  }
  
  public function destroy(Genre $genre)
  {
    $genre->delete();

    return response()->json([
        'type' => 'success',
        'text' => "El género musical <b>$genre->name</b> fue eliminado!"
    ]);
  }
  
  public function qryGenres()
  {
    $genres = Genre::orderBy('name')
        ->withCount('records')
        ->get();

    return $genres;       // Devuelve el resultado (como JSON)
  }
}
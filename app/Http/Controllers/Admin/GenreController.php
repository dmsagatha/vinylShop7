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
    $genres = Genre::orderBy('name')
        ->withCount('records')
        ->get();
    $result = compact('genres');
    Json::dump($result);    // http://localhost:3000/admin/genres?json

    return view('admin.genres.index', $result);
  }
  
  public function create()
  {
    $genre = new Genre();
    $result = compact('genre');

    return view('admin.genres.create', $result);
  }
  
  public function store(Request $request)
  {
    $this->validate($request,[
        'name' => 'required|min:3|unique:genres,name'
    ]);
    
    $genre = new Genre();
    $genre->name = $request->name;
    $genre->save();

    session()->flash('success', "El género musical <b>$genre->name</b> fue creado!");

    return redirect('admin/genres');
  }
  
  public function show(Genre $genre)
  {
    return redirect('admin/genres');
  }
  
  public function edit(Genre $genre)
  {
    $result = compact('genre');
    Json::dump($result);

    return view('admin.genres.edit', $result);
  }
  
  public function update(Request $request, Genre $genre)
  {
    $this->validate($request,[
        'name' => 'required|min:3|unique:genres,name,' . $genre->id
    ]);

    $genre->name = $request->name;
    $genre->save();

    session()->flash('success', "El género musical <b>$genre->name</b> fue actualizado!");

    return redirect('admin/genres');
  }
  
  public function destroy(Genre $genre)
  {
    $genre->delete();

    session()->flash('success', "El género musical <b>$genre->name</b> fue eliminado!");

    return redirect('admin/genres');
  }
}
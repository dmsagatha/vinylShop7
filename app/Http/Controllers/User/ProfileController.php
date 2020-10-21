<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
  // Edit user profile
  public function edit()
  {
    return view('user.profile');
  }

  // Update user profile
  public function update(Request $request)
  {
    // Validate $request
    $this->validate($request,[
      'name'  => 'required',
      'email' => 'required|email|unique:users,email,' . auth()->id()
    ]);

    // Actualizar el usuario en la BD y redireccionar a la pag. anterior
    $user = User::findOrFail(auth()->id());
    $user->name  = $request->name;
    $user->email = $request->email;
    $user->save();
    
    session()->flash('success', 'Su perfil fue actualizado!');

    return back();
  }
}
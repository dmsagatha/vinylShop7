<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
  // Edit user password
  public function edit()
  {
    return view('user.password');
  }

  // Update and encrypt user password
  public function update(Request $request)
  {
    // Validate $request
    $this->validate($request,[
      'current_password' => 'required',
      'password' => 'required|min:6|confirmed',
    ]);

    // Actualice la contraseña de usuario cifrada en la BD y redirija a la página anterior
    $user = User::findOrFail(auth()->id());
    if (!Hash::check($request->current_password, $user->password)) {
        session()->flash('danger', "Su actual contraseña no coincide con la de la base de datos");
        return back();
    }
    $user->password = Hash::make($request->password);
    $user->save();
    
    session()->flash('success', 'Su contraseña ha sido actualiza!');

    return back();
  }
}
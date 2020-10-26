<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
  public function show()
  {
    return view('contact');
  }

  // Enviar correo electrónco
  public function sendEmail(Request $request)
  {
    // Validar formulario

    // Enviar correo electrónco
    $this->validate($request,[
      'name'    => 'required',
      'email'   => 'required|email',
      'message' => 'required|min:10'
    ]);

    // $email = new ContactMail();
    $email = new ContactMail($request);
    // Descomentar esta línea para mostrar el resultado en el navegador
    // return $email; 
    Mail::to($request)      // o Mail::to($request->email, $request->name)
        ->send($email);

    // Flash de los valores del formulario rellenado a la sesión
    $request->flash();

    // Envía un mensaje de éxito a la sesión - session()->flash('key','value')
    session()->flash('success', 'Gracias por su mensaje.<br>Nos pondremos en contacto con usted lo mas pronto posible.');
    //return redirect('contact-us')->with('success', 'Thank you ...');

    // Redireccionar al enlace de contact-us ( NO a view('contact')!!! )
    return redirect('contact-us');
  }
}
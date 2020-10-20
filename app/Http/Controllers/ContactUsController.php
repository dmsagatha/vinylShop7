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

  // Send email
  public function sendEmail(Request $request)
  {
    // Validate form

    // Send email
    $this->validate($request,[
      'name'    => 'required',
      'email'   => 'required|email',
      'message' => 'required|min:10'
    ]);

    // $email = new ContactMail();
    $email = new ContactMail($request);
    // Descomente esta línea para mostrar el resultado en el navegador
    // return $email; 
    Mail::to($request)      // o Mail::to($request->email, $request->name)
        ->send($email);

    // Flash de los valores del formulario rellenado a la sesión
    $request->flash();
    // Envía un mensaje de éxito a la sesión - session()->flash('key','value')
    session()->flash('success', 'Gracias por su mensaje.<br>Nos pondremos en contacto con usted lo mas pronto posible.');
    //return redirect('contact-us')->with('success', 'Thank you ...');

    // Redirect to the contact-us link ( NOT to view('contact')!!! )
    return redirect('contact-us');
  }
}
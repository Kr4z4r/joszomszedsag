<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Error;

class ErrorController extends Controller {
  public function index() {
    return view('error_reporting');
  }
  public function submit(Request $request) {
    
    $validatedData = $request->validate(array(
      'email' => 'required|email',
      'desc' => 'required',
      'privacy_policy' => 'required'
    ));
    
    $email = $request->input('email');
    $description = $request->input('desc');
    $error = new Error();
    $error->email = $email;
    $error->description = $description;
    $error->status = 0;
    
    if($error->save()) {
      return redirect(route('error_reporting'))
        ->with(array(
          'error_status' => 1,
          'message' => __('Köszönjük bejelentését, a hiba elhárítását hamarosan megkezdjük')
          ));
    }
    else {
      return redirect(route('error_reporting'))
        ->with(array(
          'error_status' => 0,
          'message' => __('Hiba történt a hibajegy létrehozásánál')
        ));
    }
    
    
  }
}
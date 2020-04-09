<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LegalController extends \App\Http\Controllers\Controller {
    public function legal_text() {
      return view('legal.privacy');
    }
  public function privacy_text() {
    return view('legal.privacy');
  }
  public function cookie_text() {
    return view('legal.cookie');
  }
}
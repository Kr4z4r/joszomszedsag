<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Authentication Language Lines
  |--------------------------------------------------------------------------
  |
  | The following language lines are used during authentication for various
  | messages that we need to display to the user. You are free to modify
  | these language lines according to your application's requirements.
  |
  */

  ////
  // auth/login.blade.php
  ////
  'failed' => 'Hibás email cím vagy jelszó',
  'throttle' => 'Túl sok bejelentkezési kísérlet! Kérjük próbálja meg :seconds másodperc múlva!',
  'login' => 'Bejelentkezés',
  'email' => 'E-Mail cím',
  'password' => 'Jelszó',
  'first_login_pswd_text' => 'Ha ez az első bejelentkezése, akkor jelszavát elmentjük a felhasználójához!',
  'remember_me' => 'Emlékezz rám',
  'forgot_password_q' => 'Elfelejtette a jelszavát?',

  ////
  // auth/verify.blade.php
  ////
  'confirm_email' => 'E-mail cím megerősítése',
  'confirm_email_sent' => 'Egy új megerősítő link lett küldve az email címére.',
  'confirm_email_before_continue' => 'Mielőtt továbblépne meg kell erősítenie az e-mail címét!',
  'check_confirm_email' => 'Kérjük nézze meg az email fiókját a megerősítő e-mailhez, vagy ha nem találja kérjen újat az alábbi gombra kattintva',
  'resend_confirm_email' => 'Megerősítő email újraküldése',

  ////
  // auth/passwords/email.blade.php
  ////
  'password_recovery' => 'Jelszó visszaállítás',
  'send_email' => 'Email küldése',

  ////
  // auth/passwords/reset.blade.php
  ////
  'repeat_password' => 'Jelszó újra',
  'save' => 'Mentés',

];

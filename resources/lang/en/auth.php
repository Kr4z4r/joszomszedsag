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

  'failed' => 'These credentials do not match our records.',
  'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
  'login' => 'Login',
  'email' => 'Email',
  'password' => 'Password',
  'first_login_pswd_text' => 'If this is your first login, we will save your password for the account!',
  'remember_me' => 'Remember me',
  'forgot_password_q' => 'Forgot your password?',

  ////
  // auth/verify.blade.php
  ////
  'confirm_email' => 'Email verification',
  'confirm_email_sent' => 'We have sent you a new verification link in email!',
  'confirm_email_before_continue' => 'Before you continue, you have to confirm your email!',
  'check_confirm_email' => 'Please check your inbox for the verification email. You can request another email here.',
  'resend_confirm_email' => 'Resend verification email',

  ////
  // auth/passwords/email.blade.php
  ////
  'password_recovery' => 'Password recovery',
  'send_email' => 'Send email',

  ////
  // auth/passwords/reset.blade.php
  ////
  'repeat_password' => 'Password again',
  'save' => 'Save',

];

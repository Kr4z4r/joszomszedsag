<?php
    $sent = isset($sent) ? $sent : FALSE;
    $url  = url('/phoneverification' . ( $sent ? '/check' : ''))
?>
@extends('layout')

@section('title', __('Please verify your phone'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12">
                <form method="post" action="{{ $url }}" class="card-panel hoverable">
                    {{ csrf_field() }}
                    <div class="row">
                        <h4 class="center-align">
                            We need to verify your phone number:
                        </h4>
                    </div>

                    <div class="row form-errors">
                        <ul>
                            @if($errors->any())
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                    <div class="row">
                        <div class="input-field col s12 m3">
                            <input required name="phone" id="phone" type="tel" class="validate" value="{{ old('phone', request('phone')) }}">
                            <label for="phone">Phone number:</label>
                        </div>
                    </div>

                    @if( $sent )
                        <div class="row">
                            <div class="input-field col s12 m3">
                                <input required name="code" id="code" type="text" class="validate" value="{{ old('code') }}">
                                <label for="code">SMS Code:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 center-align">
                                <button class="btn-large btn-alternate" type="submit">
                                    Verify code
                                    <i class="material-icons right">send</i>
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="input-field col s12 center-align">
                                <button class="btn-large btn-alternate" type="submit">
                                    Send code
                                    <i class="material-icons right">send</i>
                                </button>
                            </div>
                        </div>
                    @endif


                </form>
            </div>
        </div>
    </div>
@endsection
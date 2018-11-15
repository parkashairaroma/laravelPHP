 @section('bodyClass', 'store aromax subnav')
@section('currentNav', 6)
@section('currentSubNav', 0)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-store')

<div class="container">

	<div class="content-block">

		{!! Form::open(['method' => 'post', 'id' => 'form']) !!} 

     <div class="text-block">
         <h2>Change Email</h2>

         <div class="form-group">
             <div class="error">
                 <span class="message">{{ $errors->first('error') }}</span>
             </div>
        </div>

             <div class="form-group">
                 <label for="email">Current Email</label>
                 {{ $authedStoreUser->acc_email }}
             </div>

             <div class="form-group @if ($errors->has('current_password')) error @endif">
                 <label for="current_password">Current Password {!! $errors->first('current_password', '<span class="message">:message</span>') !!}</label>
                 {{ Form::password("current_password", ['id' => 'current_password', 'class' => 'ui-text']) }}
             </div>

             <div class="form-group @if ($errors->has('email') || $errors->has('email_confirmation')) error @endif">
                 <label for="email">New Email {!! $errors->first('email', '<span class="message">:message</span>') !!}</label>
                 {{ Form::text("email", null, ['id' => 'email', 'class' => 'ui-text']) }}
             </div>

             <div class="form-group @if ($errors->has('email')) error @endif">
                 <label for="email_confirmation">Confirm Email {!! $errors->first('email', '<span class="message">:message</span>') !!}</label>
                 {{ Form::text("email_confirmation", null, ['id' => 'email_confirmation', 'class' => 'ui-text']) }}
             </div>

             <div class="form-group">
                 {!! Form::submit('Save', ['class' => 'ui-button']) !!}
             </div>

         </div>

         {!! Form::close() !!}

     </div>

</div>

@stop
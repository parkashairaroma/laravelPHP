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
         <h2>Change Password</h2>


         <div class="form-group">
             <div class="error">
                 <span class="message">{{ $errors->first('error') }}</span>
             </div>
        </div>

             <div class="form-group @if ($errors->has('current_password')) error @endif">
                 <label for="current_password">Old Password{!! $errors->first('current_password', '<span class="message">:message</span>') !!}</label>
                 {{ Form::password('current_password', ['id' => 'current_password', 'class' => 'ui-text']) }}
             </div>

             <div class="form-group @if ($errors->has('password') || $errors->has('password_confirmation')) error @endif">
                 <label for="password">Password {!! $errors->first('password', '<span class="message">:message</span>') !!}</label>
                 {{ Form::password('password', ['id' => 'password', 'class' => 'ui-text']) }}
             </div>

             <div class="form-group @if ($errors->has('password')) error @endif">
                 <label for="password_confirmation">Confirm Password {!! $errors->first('password', '<span class="message">:message</span>') !!}</label>
                 {{ Form::password('password_confirmation', ['id' => 'password_confirmation', 'class' => 'ui-text']) }}
             </div>

             <div class="form-group">
                 {!! Form::submit('Save', ['class' => 'ui-button']) !!}
             </div>

         </div>

         {!! Form::close() !!}

     </div>

</div>


@stop
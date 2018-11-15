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

         @if (Session::has('message'))

         <p class="alert">{{ Session::get('message') }}</p>

         @else

         <div class="form-group">
             <div class="error">
                 <span class="message">{{ $errors->first('error') }}</span>

             </div>
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

             @endif

         </div>

         {!! Form::close() !!}

     </div>

</div>

<script>
/* Hardcoded for now */
$( document ).ready(function() {
    document.title = "Reset Password - " + {{ websitetitle() }};
});
</script>

@stop
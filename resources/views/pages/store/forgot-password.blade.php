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
         <h2>Reset Password</h2>
         @if (Session::has('error'))
         <div class="form-group">
             <div class="error">
                 <span class="message">{{ Session::get('error') }}</span>
             </div>
         </div>
         @endif
         @if (Session::has('message'))
         <div class="form-group">
             <div class="error">
                 <span class="alert">{{ Session::get('message') }}</span>
             </div>
         </div>
         @else


         <div class="form-group">
             <div class="error">
                 <span class="message">{{ $errors->first('error') }}</span>
             </div>
        </div>

             <div class="form-group @if ($errors->has('email')) error @endif">
                 <label for="email">Email {!! $errors->first('email', '<span class="message">:message</span>') !!}</label>
                 {{ Form::text('email', null, ['id' => 'email', 'class' => 'ui-text']) }}
             </div>

             <div class="form-group">
                 {!! Form::submit('Reset', ['class' => 'ui-button']) !!}
             </div>

             @endif

         </div>

         {!! Form::close() !!}

     </div>
	
</div>



@stop

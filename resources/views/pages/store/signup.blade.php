@section('bodyClass', 'store aromax subnav')
@section('currentNav', 6)
@section('currentSubNav', 0)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-store')

<div class="container">
	
	<div class="content-block">
		
		<div class="text-block">
			<h2>Become a Member</h2>
			
			{!! Form::open(['method' => 'post', 'id' => 'form']) !!} 

				<div class="form-group @if ($errors->has('firstname')) error @endif">
					<label for="firstname">First name {!! $errors->first('firstname', '<span class="message">:message</span>') !!}</label>
					{{ Form::text('firstname', null, ['id' => 'firstname', 'class' => 'ui-text']) }}
				</div>
				<div class="form-group @if ($errors->has('lastname')) error @endif">
					<label for="lastname">Last name {!! $errors->first('lastname', '<span class="message">:message</span>') !!}</label>
					{{ Form::text('lastname', null, ['id' => 'lastname', 'class' => 'ui-text']) }}
				</div>
				<div class="form-group @if ($errors->has('email')) error @endif">
					<label for="email">Email {!! $errors->first('email', '<span class="message">:message</span>') !!}</label>
					{{ Form::text('email', null, ['id' => 'email', 'class' => 'ui-text']) }}
				</div>
				<div class="form-group @if ($errors->has('password')) error @endif">
					<label for="password">Password {!! $errors->first('password', '<span class="message">:message</span>') !!}</label>
					{{ Form::password('password', ['id' => 'password', 'class' => 'ui-text']) }}
				</div>
                
                <div class="form-group @if ($errors->has('recaptchaError')) error @endif">
                    <span class="message">@if ($errors->has('recaptchaError')){!! "Please verify that you are not a robot." !!} @endif</span>
                    <div class="g-recaptcha" data-sitekey="{{ $recaptchaSiteKey }}"></div>
                </div>
				
				<div class="form-action fa-a">
					<a href="/store/signup" class="ui-button submit-form">Create account</a>
					<p class="note"><small>By joining Air Aroma through email or Facebook sign-up, you agree to Air Aroma&rsquo;s <a href="/legal" target="_blank">Terms and Conditions</a></small></p>
				</div>
				
			{!! Form::close() !!} 
			
		</div>
	
	</div>
	
</div>

{{-- Recaptcha --}}
{!! Html::script('https://www.google.com/recaptcha/api.js') !!}
@stop
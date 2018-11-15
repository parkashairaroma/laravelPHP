@section('bodyClass', 'store aromax subnav')
@section('currentNav', 6)
@section('currentSubNav', 0)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-store')

<div class="container">
	
	<div class="content-block cb-a">
		
		<div class="text-block">
			<h2>{!! $translate->token('h_signintoairaroma') !!}</h2>

			{!! Form::open(['method' => 'post', 'id' => 'form']) !!} 
				<div class="form-group">
                    <div class="error">
                        @if ($errors->first('error_code') == 3)
                            <span class="message">{{ $errors->first('error') }}</span> <a href="/store/reactivation">Resend Activation Link</a>
                        @else
                            <span class="message">{{ $errors->first('error') }}</span>
                        @endif
                    </div>
				</div>
				<div class="form-group @if ($errors->has('email')) error @endif">
					<label for="email">Email {!! $errors->first('email', '<span class="message">:message</span>') !!}</label>
					<input type="email" name="email" class="ui-text">
				</div>
				
				<div class="form-group @if ($errors->has('password')) error @endif">
					<label for="password">Password {!! $errors->first('password', '<span class="message">:message</span>') !!}</label>
					<input type="password" name="password" class="ui-text">
				</div>
				
				<div class="form-action fa-a">
					<div class="button-group">
						<input type="submit" value="Sign In" class="ui-button">
						<a href="/store/social/facebook/login" class="ui-button button-facebook"><span class="button-icon button-icon-facebook"></span><small>{!! $translate->token('link_signinwithfacebook') !!}</small></a>
					</div>
					<p class="note"><small><a href="/store/forgot-password">{!! $translate->token('link_forgotyourpassword') !!}</a></small></p>
				</div>
				
			{!! Form::close() !!} 
			
		</div>
	
	</div>
	
	<div class="content-block">
		
		<div class="text-block">
			<h3>{!! $translate->token('h_becomeamember') !!}</h3>
			
			<form>
				<div class="form-action fa-a">
					<a href="/store/signup" class="ui-button">{!! $translate->token('link_createaccount') !!}</a>
					<p class="note"><small>{!! $translate->token('p_signupdisclaimer') !!}<a href="/legal" target="_blank">{!! $translate->token('p_termsandconditions') !!}</a></small></p>
				</div>
			</form>
			
		</div>
	
	</div>
	
</div>

@stop
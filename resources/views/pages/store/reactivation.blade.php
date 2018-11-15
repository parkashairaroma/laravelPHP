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
			<h2>Didn't receive your activation email?</h2>

			{!! Form::open(['method' => 'post', 'id' => 'form']) !!} 
				<div class="form-group">
                    <div class="error">
                        <span class="message">Enter the email address you registered with and we'll resend your activation email.</span>
                    </div>
				</div>
				<div class="form-group @if ($errors->has('error_msg')) error @endif">
					<label for="email">Email {!! $errors->first('error_msg', '<span class="message">:message</span>') !!}</label>
					<input type="email" name="email" class="ui-text">
				</div>

            <div class="form-action fa-a">
                <div class="button-group">
                    <input type="submit" value="Submit" class="ui-button" />
                </div>
            </div>

			{!! Form::close() !!} 
			
		</div>
	
	</div>
</div>

@stop
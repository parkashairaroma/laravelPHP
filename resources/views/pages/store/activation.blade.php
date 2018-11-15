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
			<h2>{{$errors->first('error_header')}}</h2>
            @if ($errors->first('error_code') == 3)
			    <p>{{$errors->first('error_msg')}}</p> <a href="/store/reactivation">Resend Activation Link</a>
            @else
                <p>{{$errors->first('error_msg')}}</p>
            @endif
		</div>
	
	</div>
	
</div>

@stop
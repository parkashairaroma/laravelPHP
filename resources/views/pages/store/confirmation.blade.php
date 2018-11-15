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
            <h2>Welcome to Air Aroma</h2>

            <div class="form-group">
                <label>
                    Thanks for signing up.
                </label>
            </div>

            <div class="form-group">
                <label>
                    An activation email has been sent to the provided email address.<br/>
                    To activate your account please follow the instructions within your activation email, which was sent to: <b><?=$emailaddress?></b>
                </label>
            </div>

            <div class="form-group">
                <label>
                    If an email does not arrive, please check your Junk Mail Folder.
                </label>
            </div>
            
        </div>
	
	</div>
	

	
</div>

@stop
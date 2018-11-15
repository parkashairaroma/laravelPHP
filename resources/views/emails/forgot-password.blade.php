@extends('emails.layouts.base')

@section('content')
	<p>A member of the Air Aroma Online Store has requested a password reset using your email address.</p>
	<p>Please click on the link below to complete the request.</p>
	<p><a href="{{ $resetLink }}">{{ $resetLink }}</a></p>
@stop
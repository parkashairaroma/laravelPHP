@section('bodyClass', 'store fragrances subnav')
@section('currentNav', 6)
@section('currentSubNav', 1)	

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-store')

<div class="container">

	<div class="content-block">
		
		<div class="text-block">
			<h3>{!! $translate->token('h_fragrances') !!}</h3>
			<p><a href="/store/aroma-oils">Aroma Oils</a></p>
			<p><a href="/store/essential-oils">Essential Oils</a></p>
			<!--<p><a href="/store/arobalance">Arobalance</a></p>-->
		</div>

	</div>

</div>

@stop
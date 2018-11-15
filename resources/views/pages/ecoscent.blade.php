@section('bodyClass', 'products dark subnav')
@section('currentNav', 2)
@section('currentSubNav', 1)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.products.nav-ecoscent')

<div class="hero-block hero-product-ecoscent large">
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_ecoscent') !!}</h1>
				<h3>{!! $translate->token('text_ecoscent') !!}</h3>
			</div>
		</div>
	</div>
</div>

<div class="container">
	
	<div class="content-block cb-a">
		<div class="text-block">
			<h2>{!! $translate->token('h_advancedscent') !!}</h2>
			<p>{!! $translate->token('text_advancedscent') !!}</p>
			<figure><img src="/images/products/ecoscent.jpg" alt="{!! $translate->token('h_advancedscent', false) !!}"></figure>
		</div>
	</div>
	
	<div class="content-block">
		<div class="text-block tb-a tb-c">
			<h2>{!! $translate->token('h_scentingneeds') !!}</h2>
			<p>{!! $translate->token('text_scentingneeds') !!}</p>
		</div>
		<div class="grid large divider div-a">
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<div class="feature-icon icon-interval"></div>
							<h3>{!! $translate->token('h_timer') !!}</h3>
							<p>{!! $translate->token('text_timer') !!}</p>
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<div class="feature-icon icon-hvac"></div>
							<h3>{!! $translate->token('h_hvac') !!}</h3>
							<p>{!! $translate->token('text_hvac') !!}</p>
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<div class="feature-icon icon-adjustable"></div>
							<h3>{!! $translate->token('h_adjustable') !!}</h3>
							<p>{!! $translate->token('text_adjustable') !!}</p>
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<div class="feature-icon icon-six-scents"></div>
							<h3>{!! $translate->token('h_sixscents') !!}</h3>
							<p>{!! $translate->token('text_sixscents') !!}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="content-block cb-b">
		<div class="text-block tb-a">
			<h2>{!! $translate->token('h_airconditioner') !!}</h2>
			<p>{!! $translate->token('text_airconditioner1') !!}</p>
			<figure><img src="/images/products/ecoscent-diagram.png" alt="{!! $translate->token('h_airconditioner', false) !!}"></figure>
			<p>{!! $translate->token('text_airconditioner2') !!}</p>
		</div>
	</div>
	
	<div class="content-block">
		<div class="text-block tb-a">
			<h2>{!! $translate->token('h_startscenting') !!}</h2>
			<p>{!! $translate->token('text_startscenting') !!}</p>
			<p>{!! $link->create('/contact', ['class' => 'ui-button ui-a'])->full('link_contact') !!}</p>
		</div>
	</div>
	
</div>

@stop
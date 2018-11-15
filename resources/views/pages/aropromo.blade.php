@section('bodyClass', 'products dark subnav')
@section('currentNav', 2)
@section('currentSubNav', 1)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.products.nav-aropromo')

<div class="hero-block hero-product-aropromo large">
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_aropromo') !!}</h1>
				<h3>{!! $translate->token('text_aropromo') !!}</h3>
			</div>
		</div>
	</div>
</div>

<div class="container">
	
	<div class="content-block cb-a">
		<div class="text-block">
			<h2>{!! $translate->token('h_whatisaropromo') !!}</h2>
			<p>{!! $translate->token('text_whatisaropromo') !!}</p>
			<blockquote>
				<header>{!! $translate->token('text_quote_header') !!}<br>{!! $translate->token('text_quote_content') !!}</header>
			</blockquote>
		
		</div>
	</div>
	
	<div class="content-block">
		<div class="text-block">
			<h2>{!! $translate->token('h_designed') !!}</h2>
			<p>{!! $translate->token('text_designed') !!}</p>
		</div>
	</div>
	
	<div class="content-block cb-b">
		<div class="text-block">
			<figure><img src="/images/products/aropromo-example-ajax.jpg"  alt="{!! $translate->token('h_designed', false) !!}" /></figure>
		</div>
	</div>
	
	<div class="content-block">
		<div class="text-block">
			<div class="sub-section">
				<h3>{!! $translate->token('h_yourbrand') !!}</h3>
				<p>{!! $translate->token('text_yourbrand') !!}</p>
			</div>
			<div class="sub-section">
				<h3>{!! $translate->token('h_yourdisplay') !!}</h3>
				<p>{!! $translate->token('text_yourdisplay') !!}</p>
			</div>
			<div class="sub-section">
				<h3>{!! $translate->token('h_yourscent') !!}</h3>
				<p>{!! $translate->token('text_yourscent') !!}</p>
			</div>			
		</div>
	</div>
	
	<div class="content-block cb-b">
		<div class="text-block">
			<h2>{!! $translate->token('h_aropromoaward') !!}</h2>
			<p>{!! $translate->token('text_aropromoaward') !!}</p>
			<figure><img src="/images/products/aropromo-award-popai.png" style="max-width:240px; width: 33%;" alt="{!! $translate->token('h_aropromoaward', false) !!}" /></figure>
		</div>
	</div>
	
	<div class="content-block">
		<div class="text-block">
			<h2>{!! $translate->token('h_companies') !!}</h2>
			<p>{!! $translate->token('text_companies') !!}</p>
		</div>

		<div class="grid square small hairline">

			<!-- Client Logo -->
			@foreach ($clients as $client)
			<div class="box" weight="{{ $client->cli_weight }}">
				<a class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-icon">
								<img src="{{ $clientLogoPath }}{{ $client->cli_slug }}.png" alt="{{ $client->cli_name }}">
							</div>
						</div>
					</div>
				</a>
			</div>
			@endforeach

		</div>
		<div class="grid more hairline">
			<!-- View More -->
			<div class="box">
       <a href="{{ $link->create('/clients')->url() }}" class="box-cell">
           <div class="tile">
               <div class="tile-content">
                   <div class="tile-label">
                       <h3>{!! $translate->token('link_viewmoreclients') !!}</h3>
                   </div>
               </div>
           </div>
       </a>
			</div>
		</div>
	</div>
	
</div>

@stop
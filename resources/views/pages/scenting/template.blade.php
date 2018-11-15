@section('titleTag', 'Who&rsquo;s Scenting - Hotels')
@section('bodyClass', 'marketing')
@section('currentNav', 1)

@extends('layouts.pages')

@section('content')

<div class="hero-block">
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>Events</h1>
				<h2>From the runway to weddings and tradeshow events, capture your audience with a uniqiue olfactory experiece.</h2>
			</div>
		</div>
	</div>
</div>

<div class="container">
	
	<div class="content-block">
		<div class="grid square large">
			<!-- Industry Icon -->
			<div class="box dark">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-icon">
								<img src="/images/industry/hotels.png" alt="Hotels">
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Stretch Image -->
			<div class="box dark">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-image">
								<img src="/images/tiles/tile-industry-hotels.jpg">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="content-block cb-a">
		<div class="text-block">
			<h2>TITLE</h2>
			<p>Lorem ipsum dolor sit amet, eiusmod ipsum vel cursus tortor. Proin vulputate erat, enim aliquam massa. Platea leo augue suscipit ultricies amet. Nec consequat, natoque nunc bibendum fermentum elit duis aenean, amet lectus vivamus sit mauris cras leo, nulla ea ac ridiculus neque, commodo ante. Velit lorem, mauris et animi aenean accumsan aenean fusce. Wisi justo quisque curabitur consectetuer, ad amet accumsan congue ut, amet pellentesque cras quam sed lobortis vulputate, est molestie sem in elit dapibus. Integer est viverra pellentesque fringilla, erat magna sapien eu amet libero donec. Ornare mauris, sapien porta elit vel eleifend, feugiat diam a elit, lacinia metus sit, molestie pharetra viverra elit.</p>
		</div>
	</div>
	
	<div class="content-block cb-b">
		<div class="text-block tb-b">
			<blockquote>
				<p>QUOTE</p>
			</blockquote>
		</div>
	</div>
	
	<div class="content-block cb-a">
		<div class="text-block">
			<h2>TITLE</h2>
			<p>Lorem ipsum dolor sit amet, eiusmod ipsum vel cursus tortor. Proin vulputate erat, enim aliquam massa. Platea leo augue suscipit ultricies amet. Nec consequat, natoque nunc bibendum fermentum elit duis aenean, amet lectus vivamus sit mauris cras leo, nulla ea ac ridiculus neque, commodo ante. Velit lorem, mauris et animi aenean accumsan aenean fusce. Wisi justo quisque curabitur consectetuer, ad amet accumsan congue ut, amet pellentesque cras quam sed lobortis vulputate, est molestie sem in elit dapibus. Integer est viverra pellentesque fringilla, erat magna sapien eu amet libero donec. Ornare mauris, sapien porta elit vel eleifend, feugiat diam a elit, lacinia metus sit, molestie pharetra viverra elit.</p>
		</div>
	</div>
	
	<div class="content-block cb-a">
		<div class="grid large divider div-a">
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<div class="feature-icon icon-tick"></div>
							<h3>Customer satisfaction</h3>
							<p>Scenting has been found to reduce the perceived time spent in a branch or waiting in line and service levels are evaluated more favorably.</p>
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<div class="feature-icon icon-star"></div>
							<h3>Customer retention</h3>
							<p>A positive experience provided through scent can increase retention and business performance.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="grid square small hairline">

			<!-- Client Logo -->
			@foreach ($clients as $client)
			<div class="box">
       <a href="{{ $link->create('/clients')->url() }}/{{ $client->cli_slug }}" class="box-cell">
           <div class="tile">
               <div class="tile-content">
                   <div class="tile-icon">
                       <img src="{{ $clientLogoPath }}/{{ $client->cli_slug }}.png" alt="{{ $client->cli_name }}" />
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
                       <h3>View more clients</h3>
                   </div>
               </div>
           </div>
       </a>
			</div>
		</div>

	</div>
	
	<div class="content-block">
		<div class="text-block tb-a">
			<h2>Start scenting your hotel</h2>
			<p>Contact an Air Aroma representative, we&rsquo;ll get your business smelling great in no time.</p>
			<p>
<a class="ui-button ui-a" href="{{ $link->create('/contact')->url() }}">Contact us</a></p>
		</div>
	</div>
	
</div>

@stop
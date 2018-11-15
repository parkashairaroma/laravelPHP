@section('bodyClass', 'products dark subnav')
@section('currentNav', 2)
@section('currentSubNav', 2)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.products.nav-aropromo')

<div class="hero-block hero-product-aropromo-how large">
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>{!! $translate->token('h_pointofsales') !!}</h1>
				<h3>{!! $translate->token('text_pointofsales') !!}</h3>
			</div>
		</div>
	</div>
</div>

<div class="container">
	
	<div class="content-block cb-a">
		
		<!-- Text -->
		<div class="text-block">
			<h2>{!! $translate->token('h_howdoesitwork') !!}</h2>
			<p>{!! $translate->token('text_howdoesitwork') !!}</p>
			
			<!-- Inner Icon Row -->
			<div class="grid inner">
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="text-block">
								<div class="feature-icon icon-power"></div>
								<h4>{!! $translate->token('h_battery') !!}</h4>
							</div>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="text-block">
								<div class="feature-icon icon-money"></div>
								<h4>{!! $translate->token('h_lowcost') !!}</h4>
							</div>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="text-block">
								<div class="feature-icon icon-sales"></div>
								<h4>{!! $translate->token('h_increasedsales') !!}</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>

	</div>
	
	<div class="content-block cb-a">
		
		<!-- Text -->
		<div class="text-block">
			<h2>{!! $translate->token('h_process') !!}</h2>
			<p>{!! $translate->token('text_process') !!}</p>
		</div>
		
		<!-- 2x1 Grid -->
		<div class="grid square large">
			<!-- Text Tile -->
			<div class="box dark">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-label cover">
								<h2>{!! $translate->token('text_pos') !!}</h2>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Image Tile -->
			<div class="box">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-image">
								<img src="/images/tiles/tile-product-aropromo-soupline.jpg" alt="{!! $translate->token('h_process', false) !!}">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Text -->
		<div class="text-block tb-c">
			<h2>{!! $translate->token('h_howreleased') !!}</h2>
			<p>{!! $translate->token('text_howreleased') !!}</p>
		</div>
		
		<!-- 2x2 Grid -->
		<div class="grid large divider div-a">
			<div class="box">
				<div class="box-cell">
					<div class="text-block">
						<div class="feature-icon icon-push"></div>
						<h3>{!! $translate->token('h_pushed') !!}</h3>
						<p>{!! $translate->token('text_pushed') !!}</p>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="text-block">
						<div class="feature-icon icon-touch"></div>
						<h3>{!! $translate->token('h_touch') !!}</h3>
						<p>{!! $translate->token('text_touch') !!}</p>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="text-block">
						<div class="feature-icon icon-motion"></div>
						<h3>{!! $translate->token('h_motion') !!}</h3>
						<p>{!! $translate->token('text_motion') !!}</p>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="text-block">
						<div class="feature-icon icon-interval"></div>
						<h3>{!! $translate->token('h_interval') !!}</h3>
						<p>{!! $translate->token('text_interval') !!}</p>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	
	<div class="content-block">
		
		<!-- Text -->
		<div class="text-block tb-a">
			<h2>{!! $translate->token('h_contactus') !!}</h2>
			<p>{!! $translate->token('text_contactus') !!}</p>
			<p class="">{!! $link->create('/contact', ['class' => 'ui-button ui-a'])->full('link_contact') !!}</div>
		</div>
		
	</div>
	
</div>

@stop
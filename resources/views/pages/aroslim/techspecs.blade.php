@section('bodyClass', 'products subnav')
@section('currentNav', 2)
@section('currentSubNav', 2)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.products.nav-aroslim')

<div class="hero-block hb-b hero-tech">
	<div class="container">
		<div class="hero-content">
			<div class="grid large tech">
				<!-- Tech Info -->
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<h3>{!! $translate->token('h_aroslim') !!}</h3>
							<div class="techspec-image">
								<img src="/images/products/techspec-aroslim.png" alt="{!! $translate->token('h_aroslim', false) !!}">
							</div>
						</div>
					</div>
				</div>
				<!-- Tech Info -->
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<h3>&nbsp;</h3>
							<div class="spec-list">
								<h4>{!! $translate->token('h_colours') !!}</h4>
								<ul class="swatches">
									<li class="swatch-silver"><input type="radio" name="product-color" id="product-color-silver"><label for="product-color-white" title="White"><span class="swatch"></span></label></li>
									<li class="swatch-black"><input type="radio" name="product-color" id="product-color-black"><label for="product-color-black" title="Black"><span class="swatch"></span></label></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container">
	
	<div class="content-block">
		<div class="grid large tech">
			<!-- Tech Info -->
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<h3>{!! $translate->token('h_dimension') !!}</h3>
						<div class="spec-list">
							<h4>{!! $translate->token('h_size') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_height') !!}: {!! $translate->token('h_height_dim') !!}</li>
								<li>{!! $translate->token('h_diameter') !!}: {!! $translate->token('h_diameter_dim') !!}</li>
								<li>{!! $translate->token('h_diameter') !!}: {!! $translate->token('h_width_dim') !!}</li>
							</ul>
							<h4>{!! $translate->token('h_weight') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_weight_dim') !!}</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- Tech Info -->
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<h3>{!! $translate->token('h_power') !!}</h3>
						<div class="spec-list">
							<h4>{!! $translate->token('h_powersupply') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_powersupply_dim') !!}</li>
							</ul>
							<h4>{!! $translate->token('h_powerconsumption') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_powerconsumption_dim') !!}</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- Tech Info -->
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<h3>{!! $translate->token('h_scent') !!}</h3>
						<div class="spec-list">
							<h4>{!! $translate->token('h_fragrancecartridge') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_fragrancecartridge_dim') !!}</li>
							</ul>
							<h4>{!! $translate->token('h_scentcoverage') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_scentcoverage_dim') !!}</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- Tech Info -->
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<h3>{!! $translate->token('h_features') !!}</h3>
						<div class="spec-list">
							<h4>{!! $translate->token('h_controls') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_adjustable') !!}</li>
							</ul>
							<h4>{!! $translate->token('h_compatible') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_securitylock') !!}</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- Tech Info -->
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<h3>{!! $translate->token('h_inthebox') !!}</h3>
						<div class="spec-list">
							<h4>{!! $translate->token('h_boxcontents') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_aroslimtext') !!}</li>
								<li>{!! $translate->token('h_poweradapter') !!}</li>
								<li>{!! $translate->token('h_manual') !!}</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@stop
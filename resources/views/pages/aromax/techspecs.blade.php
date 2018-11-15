@section('bodyClass', 'products subnav')
@section('currentNav', 2)
@section('currentSubNav', 2)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.products.nav-aromax')

<div class="hero-block hb-b hero-tech">
	<div class="container">
		<div class="hero-content">
			<div class="grid large tech">
				<!-- Tech Info -->
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<h3>{!! $translate->token('h_aromax') !!}</h3>
							<div class="techspec-image">
								<img src="/images/products/techspec-aromax-silver.png" alt="{!! $translate->token('h_aromax', false) !!}">
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
								<h4>{!! $translate->token('h_material') !!}</h4>
								<ul>
									<li>{!! $translate->token('h_aluminum') !!}</li>
								</ul>
								<h4>{!! $translate->token('h_colours') !!}</h4>
								<ul class="swatches">
									<li class="swatch-silver"><input type="radio" name="product-color" id="product-color-silver"><label for="product-color-silver"><span class="swatch"></span></label></li>
									<li class="swatch-black"><input type="radio" name="product-color" id="product-color-black"><label for="product-color-black"><span class="swatch"></span></label></li>
									<li class="swatch-blue"><input type="radio" name="product-color" id="product-color-blue"><label for="product-color-blue"><span class="swatch"></span></label></li>
									<li class="swatch-red"><input type="radio" name="product-color" id="product-color-red"><label for="product-color-red"><span class="swatch"></span></label></li>
									<li class="swatch-gold"><input type="radio" name="product-color" id="product-color-gold"><label for="product-color-gold"><span class="swatch"></span></label></li>
									<li class="swatch-purple"><input type="radio" name="product-color" id="product-color-purple"><label for="product-color-purple"><span class="swatch"></span></label></li>
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
						<h3>{!! $translate->token('h_dimensions') !!}</h3>
						<div class="spec-list">
							<h4>{!! $translate->token('h_size') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_height') !!}: {!! $translate->token('h_height_dim') !!}</li>
								<li>{!! $translate->token('h_diameter') !!}: {!! $translate->token('h_diameter_dim') !!}</li>
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
						<h3>{!! $translate->token('h_scenttext') !!}</h3>
						<div class="spec-list">
							<h4>{!! $translate->token('h_fragrancecapacity') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_fragrancecapacity_dim') !!}</li>
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
							<h4>{!! $translate->token('h_strength') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_adjustable') !!}</li>
							</ul>
							<h4>{!! $translate->token('h_glassnebulizer') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_silencerincluded') !!}</li>
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
								<li>{!! $translate->token('h_aromaxtext') !!}</li>
								<li>{!! $translate->token('h_poweradapter') !!}</li>
								<li>{!! $translate->token('h_manual') !!}</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- Tech Info -->
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<h3>{!! $translate->token('h_instructionmanual') !!}</h3>
						<p>
							<a class="ui-button" href="/documents/aromax/aromax-manual.pdf">{!! $translate->token('link_download') !!}</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@stop
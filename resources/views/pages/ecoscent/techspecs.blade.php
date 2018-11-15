@section('bodyClass', 'products subnav')
@section('currentNav', 2)
@section('currentSubNav', 2)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.products.nav-ecoscent')

<div class="hero-block hb-b hero-tech">
	<div class="container">
		<div class="hero-content">
			<div class="grid large tech">
				<!-- Tech Info -->
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<h3>{!! $translate->token('h_ecoscentr1r2') !!}</h3>
							<div class="techspec-image">
								<img src="/images/products/techspec-ecoscent-black-r1-r2.png" alt="{!! $translate->token('h_ecoscentr1r2', false) !!}">
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
						<h3>{!! $translate->token('h_dimensions') !!}</h3>
						<div class="spec-list">
							<h4>{!! $translate->token('h_size') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_height') !!}: {!! $translate->token('h_height_dim') !!}</li>
								<li>{!! $translate->token('h_width') !!}: {!! $translate->token('h_width_dim') !!}</li>
								<li>{!! $translate->token('h_depth') !!}: {!! $translate->token('h_depth_dim') !!}</li>
							</ul>
							<h4>{!! $translate->token('h_weight') !!}</h4>
							<ul>
           <li>{!! $translate->token('h_weightr1_dim1') !!} </li>
           <li>{!! $translate->token('h_weightr1_dim2') !!} </li>
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
								<li>{!! $translate->token('h_powersupply_dim1') !!}</li>
								<li>{!! $translate->token('h_powersupply_dim2') !!}</li>
							</ul>
							<h4>{!! $translate->token('h_powerconsumption') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_powerconsumption_dim1') !!}</li>
								<li>{!! $translate->token('h_powerconsumption_dim2') !!}</li>
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
							<h4>{!! $translate->token('h_scentpoint') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_ecoscentr1_txt') !!} ({!! $translate->token('h_ecoscentr1') !!})</li>
								<li>{!! $translate->token('h_ecoscentr2_txt') !!} ({!! $translate->token('h_ecoscentr2') !!})</li>
							</ul>
							<h4>{!! $translate->token('h_fragrancecartridge') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_fragrancecartridge_dim') !!}</li>
							</ul>
							<h4>{!! $translate->token('h_scentcoverage') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_ecoscentr1_dim') !!} ({!! $translate->token('h_ecoscentr1') !!})</li>
								<li>{!! $translate->token('h_ecoscentr2_dim') !!} ({!! $translate->token('h_ecoscentr2') !!})</li>
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
								<li>{!! $translate->token('h_timersystem') !!}</li>
								<li>{!! $translate->token('h_scentoutput') !!}</li>
							</ul>
							<h4>{!! $translate->token('h_ethernetconnection') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_no') !!}</li>
							</ul>
							<h4>{!! $translate->token('h_compatibilty') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_compatibilty_txt1') !!}</li>
								<li>{!! $translate->token('h_compatibilty_txt2') !!}</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>

<div class="hero-block hb-b hero-tech">
	<div class="container">
		<div class="hero-content">
			<div class="grid large tech">
				<!-- Tech Info -->
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<h3>{!! $translate->token('h_ecoscentr4r6') !!}</h3>
							<div class="techspec-image">
								<img src="/images/products/techspec-ecoscent-black-r4-r6.png" alt="{!! $translate->token('h_ecoscentr4r6', false) !!}">
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
									<li class="swatch-black"><a href="#" title="Black"></a></li>
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
								<li>{!! $translate->token('h_height') !!}: {!! $translate->token('h_heightr4_dim') !!}</li>
								<li>{!! $translate->token('h_width') !!}: {!! $translate->token('h_widthr4_dim') !!}</li>
								<li>{!! $translate->token('h_depth') !!}: {!! $translate->token('h_depthr4_dim') !!}</li>
							</ul>
							<h4>{!! $translate->token('h_weight') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_weightr4_dim1') !!}</li>
								<li>{!! $translate->token('h_weightr4_dim2') !!}</li>
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
								<li>{!! $translate->token('h_powersupplyr4_dim1') !!}</li>
								<li>{!! $translate->token('h_powersupplyr4_dim2') !!}</li>
							</ul>
							<h4>{!! $translate->token('h_powerconsumption') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_powerconsumptionr4_dim1') !!}</li>
								<li>{!! $translate->token('h_powerconsumptionr4_dim2') !!}</li>
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
							<h4>{!! $translate->token('h_scentpoint') !!}</h4>
							<ul>
								<li>4 {!! $translate->token('h_connections') !!} ({!! $translate->token('h_ecoscentr4') !!})</li>
								<li>6 {!! $translate->token('h_connections') !!} ({!! $translate->token('h_ecoscentr6') !!})</li>
							</ul>
							<h4>{!! $translate->token('h_fragrancecartridge') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_fragrancecartridger4_dim') !!}</li>
							</ul>
							<h4>{!! $translate->token('h_scentcoverage') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_ecoscentr4_dim1') !!} ({!! $translate->token('h_ecoscentr4') !!})</li>
								<li>{!! $translate->token('h_ecoscentr4_dim2') !!} ({!! $translate->token('h_ecoscentr6') !!})</li>
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
								<li>{!! $translate->token('h_timersystem') !!}</li>
								<li>{!! $translate->token('h_scentoutput') !!}</li>
							</ul>
							<h4>{!! $translate->token('h_ethernetconnection') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_no') !!}</li>
							</ul>
							<h4>{!! $translate->token('h_compatibilty') !!}</h4>
							<ul>
								<li>{!! $translate->token('h_compatibiltyr4_txt1') !!}</li>
								<li>{!! $translate->token('h_compatibiltyr4_txt2') !!}</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>

@stop
@section('bodyClass', 'store aromax subnav')
@section('currentNav', 6)
@section('currentSubNav', 0)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-store')

<div class="container">
	
	<div class="content-block cb-a">
		
		<div class="grid large tech">
			
			<!-- Tech Info -->
			<div class="box product-image">
				<div class="box-cell">
					<div class="box-content">
						<div class="carousel product-carousel">
							<!-- Slide -->
							<div class="slide">
								<div class="store-image"><img src="/images/store/aroma-oils/rainforest/rainforest-01.jpg"></div>
							</div>
							<div class="slide">
								<div class="store-image"><img src="/images/store/aroma-oils/rainforest/rainforest-01.jpg"></div>
							</div>
							<div class="slide">
								<div class="store-image"><img src="/images/store/aroma-oils/rainforest/rainforest-01.jpg"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<!-- Tech Info -->
			<div class="box product-info">
				<div class="box-cell">
					<div class="box-content">
						<div class="product-name">
							<h3>Rainforest</h3>
							<p><span class="price">$25.000</span></p>
						</div>
						<div class="product-desc">
							<p>Taking inspiration from the forest flowers and woody notes of the Amazon, escape with the scent of Rainforest. Tropical floral aromas of orchid, jasmine and hibiscus combine with the woody scents of amber and rosewood to create the scent of a floral forest.</p>
							<p>Fragrance Notes<br>Top notes: Tiare, Orange<br>Middle notes: Orchid, Jasmine, Hibiscus<br>Base notes: Musk, Amber, Rosewood</p>
						</div>
						<div class="product-cart">
							<select id="contact-country" class="compact">
								<option>25ml</option>
								<option>250ml</option>
							</select>
							<a href="#" class="ui-button">Add to cart</a>
						</div>
					</div>
				</div>
			</div>

			<!-- Tech Info -->
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<h3>Characteristics</h3>
						<div class="spec-list">
							<ul>
								<li>Powdery</li>
								<li>Floral</li>
								<li>Woody</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			
			<!-- Tech Info -->
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<h3>Fragrances</h3>
						<div class="spec-list">
							<ul>
								<li>Highest quality ingredients</li>
								<li>PNo Alcohol or carrier oils</li>
								<p>Air Aroma aroma oils are IFRA compliant aromatherapy fragrances.</p>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="content-block">
		<div class="text-block tb-a">
			<h3>Customers also bought</h3>
		</div>
		<div class="grid square large gutter">
			<!-- Product Image -->
			<div class="box">
				<a href="#" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-info">
								<h3>Sencha</h3>
								<p><span class="price">$25.00</span></p>
							</div>
							<div class="tile-image">
								<img src="/images/tiles/tile-store-oils-sencha-new-300.png">
							</div>
							<div class="tile-overlay"><span>Buy Now</span></div>
						</div>
					</div>
				</a>
			</div>
			<!-- Product Image -->
			<div class="box">
				<a href="#" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-info">
								<h3>Lavender Linen</h3>
								<p><span class="price">$25.00</span></p>
							</div>
							<div class="tile-image">
								<img src="/images/tiles/tile-store-oils-lavender.png">
							</div>
							<div class="tile-overlay"><span>Buy Now</span></div>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>

</div>

@stop
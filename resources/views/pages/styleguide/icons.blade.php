@section('titleTag', 'Style Guide - Icons')
@section('bodyClass', 'guide subnav')
@section('currentNav', 0)
@section('currentSubNav', 3)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-guide')

<div class="hero-block hb-a">
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>Icons</h1>
				<p>A reference list of icons.</p>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="content-block">
		<div class="text-block">
			<h3>Feature Icons</h3>
			<p>Displayed within a center-aligned circle. Defaults to a black background colour but can be modified to include any colour as specified in the stylesheet.</p>
			<h4>Modifiers</h4>
			<ul>
				<li><code>.green</code> Tints icon background green.</li>
			</ul>
			<div class="grid small">
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon icon-scent"></div>
							<p><code>.icon-scent</code></p>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon icon-phone"></div>
							<p><code>.icon-phone</code></p>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon icon-cart"></div>
							<p><code>.icon-cart</code></p>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon icon-power"></div>
							<p><code>.icon-power</code></p>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon icon-sales"></div>
							<p><code>.icon-sales</code></p>
						</div>
					</div>
				</div>
				
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon icon-money"></div>
							<p><code>.icon-money</code></p>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon icon-push"></div>
							<p><code>.icon-push</code></p>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon icon-touch"></div>
							<p><code>.icon-touch</code></p>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon icon-motion"></div>
							<p><code>.icon-motion</code></p>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon icon-interval"></div>
							<p><code>.icon-interval</code></p>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon fi-green icon-recycle-pp"></div>
							<p><code>.icon-recycle-pp</code></p>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon fi-green icon-recycle-pet"></div>
							<p><code>.icon-recycle-pet</code></p>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon fi-green icon-recycle"></div>
							<p><code>.icon-recycle</code></p>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon icon-air-aroma"></div>
							<p><code>.icon-air-aroma</code></p>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon icon-adjustable"></div>
							<p><code>.icon-adjustable</code></p>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon icon-six-scents"></div>
							<p><code>.icon-six-scents</code></p>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon icon-hvac"></div>
							<p><code>.icon-hvac</code></p>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon icon-tick"></div>
							<p><code>.icon-tick</code></p>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon icon-star"></div>
							<p><code>.icon-star</code></p>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon icon-placement"></div>
							<p><code>.icon-placement</code></p>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon icon-australia"></div>
							<p><code>.icon-australia</code></p>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon icon-science"></div>
							<p><code>.icon-science</code></p>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon icon-natural"></div>
							<p><code>.icon-natural</code></p>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="box-cell">
						<div class="box-content">
							<div class="feature-icon icon-bottle"></div>
							<p><code>.icon-bottle</code></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@stop
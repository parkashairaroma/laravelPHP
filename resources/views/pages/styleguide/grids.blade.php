@section('titleTag', 'Style Guide - Grids')
@section('bodyClass', 'guide subnav')
@section('currentNav', 0)
@section('currentSubNav', 2)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-guide')

<div class="hero-block hb-a">
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>Grids</h1>
				<p>There are two main types of grid units: flexible boxes and square tiles.</p>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="content-block cb-a">
		<div class="text-block">
			<h3>Generic Grid Styles</h3>
			<p>Create grid elements by wrapping content in <code>&lt;div class="grid"&gt;</code>. Wrap each unit in <code>&lt;div class="box"&gt;</code>
			<h4>Modifiers</h4>
			<ul>
				<li><code>.large</code> one grid units per row on narrow screens, two grid units per row on wider screens.</li>
				<li><code>.small</code> two grid units per row on narrow screens, four grid units per row on wider screens.</li>
				<li><code>.square</code> turns grid units into square tiles. See the <a href="#grid-tile">Tile</a> section below.</li>
				<li><code>.grid-a</code> adds padding to the bottom of a grid block.</li>
				<li><code>.grid-b</code> adds padding to the top of a grid block.</li>
				<li><code>.hairline</code> adds a small margin between grid units.</li>
				<li><code>.gutter</code> adds a larger margin between grid units.</li>
				<li><code>.divider</code> adds a border between grid units.</li>
				<li><code>.inner</code> grids go inside <code>.text-block</code> elements.</li>
				<li><code>.nested</code> grids go inside another <code>.grid</code> element.</li>
				<li><code>.tech</code> for displaying a list of product tech specs.</li>
				<li><code>.more</code> a wide block, usually for displaying a link to more products, posts or clients.</li>
				<li><code>.blog</code> for a list of blog posts.</li>
				<li><code>.post-header</code> for an individual blog post.</li>
				<li><code>.div-a</code> removes top border from <code>.divider</code> grids. Useful when following a <code>.text-block</code> with <code>.tb-c</code></li>
			</ul>
		</div>
	</div>
	<div class="content-block cb-a" id="grid-flexible">
		<div class="text-block tb-a tb-c">
			<h3>Flexible Grids</h3>
			<p>Example of a <code>.divider</code> style grid.</p>
		</div>
		<!-- Divider Grid -->
		<div class="grid large divider div-a">
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<h3>Heading</h3>
							<p>Ea facer omnes vocent vis, has qualisque sententiae efficiendi ad, cibo liber definiebas ut duo.</p>
							<p><a href="#">Read more</a></p>
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<h3>Who&rsquo;s scenting?</h3>
							<p>Ea facer omnes vocent vis, has qualisque sententiae efficiendi ad, cibo liber definiebas ut duo.</p>
							<p><a href="#">Read more</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="content-block cb-a">
		<div class="text-block tb-a tb-c">
			<p>Example of a <code>.blog</code> style grid.</p>
		</div>
		<!-- Blog Posts -->
		<div class="grid large divider blog">
			<div class="box">
				<div class="blog-cell">
					<div class="blog-content">
						<div class="text-block">
							<h3><a href="#">Post Title</a></h3>
							<p>Ea facer omnes vocent vis, has qualisque sententiae efficiendi ad, cibo liber definiebas ut duo.</p>
							<p><a href="#">Read more</a></p>
						</div>
					</div>
					<div class="blog-image"><a href="#"><img src="/images/blog/cosmoprof-s.jpg/"></a></div>
				</div>
			</div>
			<div class="box">
				<div class="blog-cell">
					<div class="blog-content">
						<div class="text-block">
							<h3><a href="#">Post Title</a></h3>
							<p>Ea facer omnes vocent vis, has qualisque sententiae efficiendi ad, cibo liber definiebas ut duo.</p>
							<p><a href="#">Read more</a></p>
						</div>
					</div>
					<div class="blog-image"><a href="#"><img src="/images/blog/cosmoprof-s.jpg/"></a></div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="content-block cb-a">
		<div class="text-block tb-a tb-c">
			<p>Example of a <code>.tech</code> style grid.</p>
		</div>
		<!-- Tech Specs -->
		<div class="grid large tech">
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<h3>Dimensions</h3>
						<div class="spec-list">
							<h4>Size</h4>
							<ul>
								<li>Height: 9in (23cm)</li>
								<li>Diameter: 6in (16cm)</li>
							</ul>
							<h4>Weight</h4>
							<ul>
								<li>3lbs (1.4kg)</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<h3>Power</h3>
						<div class="spec-list">
							<h4>Power supply</h4>
							<ul>
								<li>100-240V 50/60Hz</li>
							</ul>
							<h4>Power consumption</h4>
							<ul>
								<li>8W</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="content-block" id="grid-tile">
		<div class="text-block tb-a">
			<h3>Tile Grids</h3>
			<p>Example of a <code>.large</code> <code>.square</code> tile grid with <code>.gutter</code>. Use <code>.client</code> on <code>.tile-label</code>.</p>
		</div>
		<!-- Client Large -->
		<div class="grid square large gutter">
			<div class="box">
				<a href="#" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-label client">
								<h3>BCBGMAXAZRIA</h3>
							</div>
							<div class="tile-image">
								<img src="/images/features/feature-bcbg.jpg">
							</div>
						</div>
						<div class="tile-overlay"><span>View</span></div>
					</div>
				</a>
			</div>
			<div class="box">
				<a href="#" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-label client">
								<h3>Beverly Wilshire Hotel</h3>
							</div>
							<div class="tile-image">
								<img src="/images/features/feature-wilshire.jpg">
							</div>
						</div>
						<div class="tile-overlay"><span>View</span></div>
					</div>
				</a>
			</div>
		</div>
	</div>
	
	<div class="content-block">
		<div class="text-block tb-a">
			<p>Example of a <code>.small</code> <code>.square</code> tile grid with <code>.hairline</code>.</p>
		</div>
		<!-- Client Small -->
		<div class="grid square small hairline">
			<div class="box">
				<a href="#" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-icon">
								<img src="/images/clients/client-logo-nissan.png" alt="Nissan">
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="box">
				<a href="#" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-icon">
								<img src="/images/clients/client-logo-societe-generale.png" alt="Societe Generale">
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="box">
				<a href="#" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-icon">
								<img src="/images/clients/client-logo-leumi.png" alt="Leumi">
							</div>
						</div>
					</div>
				</a>
			</div>
			<!-- Client Logo -->
			<div class="box">
				<a href="#" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-icon">
								<img src="/images/clients/client-logo-zara.png" alt="Zara">
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
		
		<div class="text-block tb-a">
			<p>Small square tiles can also have labels.</p>
		</div>
		
		<!-- Labelled Icons -->
		<div class="grid square small hairline">
			<div class="box">
				<a href="#" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-icon">
								<img src="/images/industry/banks.png" alt="Banks">
								<p>Banks</p>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="box">
				<a href="#" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-icon">
								<img src="/images/industry/car-showrooms.png" alt="Car Showrooms">
								<p>Car Showrooms</p>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="box">
				<a href="#" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-icon">
								<img src="/images/industry/hotels.png" alt="Hotels">
								<p>Hotels</p>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="box">
				<a href="#" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-icon">
								<img src="/images/industry/retail.png" alt="Retail">
								<p>Retail</p>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
		
	</div>
	
	<div class="content-block">
		<div class="text-block tb-a">
			<p>Example of a <code>.large</code> <code>.square</code> tile grid. Use <code>.cover</code> on <code>.tile-label</code> to align label in center of box.</p>
		</div>
		<!-- Large Square -->
		<div class="grid square large">
			
			<div class="box">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-image">
								<img src="/images/tiles/tile-signature-bottle.jpg">
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Image -->
			<div class="box dark">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-label cover">
								<h2>Your<br>/<br>Scent</h2>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="content-block">
		<div class="text-block tb-a">
			<p>Example of a <code>.post-header</code>.</p>
		</div>
		<!-- Blog Header -->
		<div class="grid large post-header">
			<div class="box">
				<div href="/clients" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-label">
								<h3>July 9, 2015</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div href="/clients" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-image">
								<img src="/images/blog/cosmoprof-s.jpg/">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="content-block">
		<div class="text-block tb-a">
			<p>Example of a <code>.more</code> grid.</p>
		</div>
		<!-- View More -->
		<div class="grid more hairline">
			<div class="box">
				<a href="#" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-label">
								<h3>View more</h3>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>
	
</div>

@stop
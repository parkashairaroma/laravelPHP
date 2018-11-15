@extends('layouts.pages')

@section('content')

<div class="container">
	<div class="content-block">
		<div class="legal-block">
			<h2>{!! $translate->token('h_sitemap') !!}</h2>
			<div class="site-map">
				<div class="nav-group">
					<ul class="nav-map">
						{!! sitemapList($sitemap, 'scent-marketing') !!}
					</ul>
					<ul class="nav-map">
						{!! sitemapList($sitemap, 'products') !!}
					</ul>
				</div>
				<div class="nav-group">
					<ul class="nav-map">
						{!!sitemapList($sitemap, 'clients') !!}
      @if (websiteId() != 5)     <!-- For Dutch site to remove Blog -->
						<li>&nbsp;</li>
						{!! sitemapList($sitemap, 'blog') !!}
      @endif
						<li>&nbsp;</li>
						{!! sitemapList($sitemap, 'about') !!}
						<li>&nbsp;</li>
						{!!sitemapList($sitemap, 'contact') !!}
					</ul>
					<ul class="nav-map">
						<li><strong><a href="/store">Store</a></strong></li>
						<li><a href="/store/aromax">Aromax</a></li>
						<li><a href="/store/fragrances">Fragrances</a></li>
						<li><a href="/store/candles">Candles</a></li>
						<li><a href="/store/signin">Sign In</a></li>
      <li><a href="/store/cart">Cart</a></li>
						<li>&nbsp;</li>
						{!! sitemapList($sitemap, 'legal') !!}
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

@stop
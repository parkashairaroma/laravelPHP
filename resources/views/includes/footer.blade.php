		</main>
		<footer role="contentinfo">
			<div class="container">
				<div class="site-map">
					<div class="nav-group">
						<ul class="nav-map">
							<li>{!! $link->create('/scent-marketing')->full('nav_scenting') !!}</li>
							<li>{!! $link->create('/products')->full('nav_products') !!}</li>
							<li>{!!$link->create('/clients')->full('nav_clients') !!}</li>
       @if (websiteId() != 5)     <!-- For Dutch site to remove Blog -->
							<li>{!! $link->create('/blog')->full('nav_blog') !!}</li>
       @endif
						</ul>
						<ul class="nav-map">

							{{-- Enable Store --}}
							@if ($enableStore)  
								<li>{!! $link->create('/store')->full('nav_store') !!}</li>
							@endif

							<li>{!! $link->create('/about')->full('nav_about') !!}</li>
							<li>{!! $link->create('/services')->full('nav_services') !!}</li>
							<li>{!!$link->create('/contact')->full('nav_contact') !!}</li>
						</ul>
					</div>
					<div class="nav-group">
						<ul class="nav-map">
       @if (websiteId() == 4)
            <li>{!! $link->create('https://www.facebook.com/AirAromaAustralia')->full('nav_facebook') !!}</li>
       @else
							<li>{!! $link->create('https://www.facebook.com/AirAroma')->full('nav_facebook') !!}</li>
       @endif
							<li>{!! $link->create('https://twitter.com/AirAroma')->full('nav_twitter') !!}</li>
							<li>{!! $link->create('https://www.instagram.com/airaroma')->full('nav_instagram') !!}</li>
							<li>{!! $link->create('https://www.youtube.com/airaroma')->full('nav_youtube') !!}</li>
						</ul>
						<ul class="nav-map">
							<li>{!! $link->create('/sitemap')->full('nav_sitemap') !!}</li>
							<li>{!! $link->create('/legal')->full('nav_legal') !!}</li>
						</ul>
					</div>
				</div>	
				<div id="sub-footer">
					{!! $translate->token('footer_copyright') !!}
					<span class="locale">
						{!!$link->create('/country')->full('footer_select_country') !!}
						<span class="flag-icon"><img src="/images/flags/{{websiteflagcode()}}.png"></span>
					</span>
				</div>
			</div>
		</footer>
		
		<!-- Scripts -->
		{!! Html::script('/scripts/slick/slick.min.js') !!}
		{!! Html::script('/scripts/semantic/transition.min.js') !!}
		{!! Html::script('/scripts/semantic/dropdown.min.js') !!}
		{!! Html::script('/scripts/semantic/search.min.js') !!}
		{!! Html::script('/scripts/semantic/api.min.js') !!}
		{!! Html::script('/scripts/scripts.js') !!}
		{!! Html::script('/scripts/fixes.js') !!}

		{{-- Administration --}}
		@if (auth()->guard('admin')->check())
			<script>
				var baseId = '{{ baseId() }}';
				var websiteId = '{{ websiteId() }}';
			</script>

			{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/tooltipster/3.3.0/js/jquery.tooltipster.js') !!}
			{{-- {!! Html::script('/cp/js/library.js') !!} // Discuss with Byron, included twice? --}}
			{!! Html::script('/cp/js/frontend.js') !!}
		@endif

		{{-- Font Family --}}
		<script type="text/javascript">
			var MTIProjectId='cf71bc08-1cbc-4770-b463-9b085f5b23f5';
			 (function() {
		        var mtiTracking = document.createElement('script');
		        mtiTracking.type='text/javascript';
		        mtiTracking.async='true';
		         mtiTracking.src='/scripts/mtiFontTrackingCode.js';
		        (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild( mtiTracking );
			   })();
		</script>

		{{-- Google Analytics --}}
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-732122-1']);
			_gaq.push(['_trackPageview']);
			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>	
	</body>
</html>
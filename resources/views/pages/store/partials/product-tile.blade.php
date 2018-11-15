@if (count($prod['variations']))
<!-- Product Image -->
<div class="box">
	<a href="/store{{ $prod['link'] }}" class="box-cell">
		<div class="tile">
			<div class="tile-content">
				<div class="tile-info">
					<h3>{{ $prod['name'] }}</h3>
					<p><span class="price">{{ $siteConfig['cur_symbol'] }}{{ collect($prod['variations'])->min('price') }}</span></p>
				</div>
				<div class="tile-image">
					@if (count($prod['variations']))
						<img src="{{ $prod['variations'][0]['image'] }}" alt="{{$prod['name'] }}">
					@endif
				</div>
				<div class="tile-overlay"><span>Buy Now</span></div>
			</div>
		</div>
	</a>
</div>
@endif
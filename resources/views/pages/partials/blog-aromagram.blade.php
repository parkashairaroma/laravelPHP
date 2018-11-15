
<div class="grid square large">
	<!-- Stretch Image -->
	<div class="box light">
		<div class="box-cell">
			<div class="tile">
				<div class="tile-content">
					<div class="tile-label cover">
						<div class="text-block">
							<h3>@aromagram</h3>
							<p>{{ $instagrams->get($id)['caption'] }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Stretch Image -->
	<div class="box dark">
		<div class="box-cell">
			<div class="tile">
				<div class="tile-content">
					<div class="tile-image">
						<img src="{{ $instagrams->get($id)['display_src'] }}"  alt="Air Aroma - Aromagram - Instagram">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
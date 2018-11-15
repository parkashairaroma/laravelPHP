<div id="nav-secondary" class="navigation">
	<div class="nav-dropdown">
		<div class="container">
			<ul class="nav-list">
				<li>
					<a href="{{ $link->create('/aroma-oils')->url() }}" id="dropdown-nav-button">
						<span id="dropdown-nav-button-icon"></span>
						{!! $link->create('/aroma-oils')->name('nav_aromaoils') !!}
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="nav-sub">
		<div class="container">
			<ul class="nav-list">
				<li<?php echo ($__env->yieldContent('currentSubNav') == 1 ? ' class="active"' : ''); ?>>{!! $link->create('/aroma-oils')->full('nav_aroma_overview') !!}</li>
				{{-- Enable Store --}}
				@if ($enableStore)  
					<li<?php echo ($__env->yieldContent('currentSubNav') == 2 ? ' class="active"' : ''); ?>><a href="/store/fragrances">{!! $translate->token('nav_aroma_buynow') !!}</a></li>
				@endif

			</ul>
		</div>
	</div>
</div>
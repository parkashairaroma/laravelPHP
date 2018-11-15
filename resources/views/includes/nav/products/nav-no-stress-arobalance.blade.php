<div id="nav-secondary" class="navigation">
	<div class="nav-dropdown">
		<div class="container">
			<ul class="nav-list">
				<li>
					<a href="{{ $link->create('/no-stress-arobalance')->url() }}" id="dropdown-nav-button">
						<span id="dropdown-nav-button-icon"></span>
						{!! $link->create('/no-stress-arobalance')->name('nav_arobalance') !!}
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="nav-sub">
		<div class="container">
			<ul class="nav-list">
				<li<?php echo ($__env->yieldContent('currentSubNav') == 1 ? ' class="active"' : ''); ?>>{!! $link->create('/no-stress-arobalance')->full('nav_products_arobalance') !!}</li>
				<li<?php echo ($__env->yieldContent('currentSubNav') == 2 ? ' class="active"' : ''); ?>>{!! $link->create('/no-stress-arobalance/how-it-works')->full('nav_arobalance_howitworks') !!}</li>

				{{-- Enable Store --}}
				@if ($enableStore)  
					<!--<li<?php echo ($__env->yieldContent('currentSubNav') == 3 ? ' class="active"' : ''); ?>><a href="/store/fragrances">{!! $translate->token('nav_arobalance_buynow') !!}</a></li>-->
				@endif
				
			</ul>
		</div>
	</div>
</div>
<div id="nav-secondary" class="navigation">
	<div class="nav-dropdown">
		<div class="container">
			<ul class="nav-list">
				<li>
					<a href="{!! $link->create('/store')->url() !!}" id="dropdown-nav-button">
						<span id="dropdown-nav-button-icon"></span>
						{!! $link->create('/store')->name('nav_store') !!}
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="nav-sub">
		<div class="container">
			<ul class="nav-list">
				<li<?php echo ($__env->yieldContent('currentSubNav') == 1 ? ' class="active"' : ''); ?>>{!! $link->create('/store/fragrances')->full('nav_store_fragrances') !!}</li>
				<li<?php echo ($__env->yieldContent('currentSubNav') == 2 ? ' class="active"' : ''); ?>>{!! $link->create('/store/candles')->full('nav_store_candles') !!}</li>
				<li<?php echo ($__env->yieldContent('currentSubNav') == 3 ? ' class="active"' : ''); ?>>{!! $link->create('/store/aromax')->full('nav_store_aromax') !!}</li>
			</ul>
		</div>
	</div>
</div>
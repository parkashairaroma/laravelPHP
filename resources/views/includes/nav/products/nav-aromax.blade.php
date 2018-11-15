<div id="nav-secondary" class="navigation">
	<div class="nav-dropdown">
		<div class="container">
			<ul class="nav-list">
				<li>
					<a href="{{ $link->create('/aromax')->url() }}" id="dropdown-nav-button">
						<span id="dropdown-nav-button-icon"></span>
						{!! $link->create('/aromax')->name('nav_aromax') !!}
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="nav-sub">
		<div class="container">
			<ul class="nav-list">
				<li<?php echo ($__env->yieldContent('currentSubNav') == 1 ? ' class="active"' : ''); ?>>{!! $link->create('/aromax')->full('nav_aromax_overview') !!}</li>
				<li<?php echo ($__env->yieldContent('currentSubNav') == 2 ? ' class="active"' : ''); ?>>{!! $link->create('/aromax/techspecs')->full('nav_aromax_techspecs') !!}</li>

				{{-- Enable Store --}}
				@if ($enableStore)  
					<li<?php echo ($__env->yieldContent('currentSubNav') == 3 ? ' class="active"' : ''); ?>>{!! $link->create('/store/aromax')->full('nav_aromax_buynow') !!}</li>
				@endif

			</ul>
		</div>
	</div>
</div>
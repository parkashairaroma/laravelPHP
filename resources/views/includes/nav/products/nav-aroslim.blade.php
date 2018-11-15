<div id="nav-secondary" class="navigation">
	<div class="nav-dropdown">
		<div class="container">
			<ul class="nav-list">
				<li>
					<a href="{{ $link->create('/aroslim')->url() }}" id="dropdown-nav-button">
						<span id="dropdown-nav-button-icon"></span>
						{!! $link->create('/aroslim')->name('nav_aroslim') !!}
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="nav-sub">
		<div class="container">
			<ul class="nav-list">
				<li<?php echo ($__env->yieldContent('currentSubNav') == 1 ? ' class="active"' : ''); ?>>{!! $link->create('/aroslim')->full('nav_aroslim_overview') !!}</li>
				<li<?php echo ($__env->yieldContent('currentSubNav') == 2 ? ' class="active"' : ''); ?>>{!! $link->create('/aroslim/techspecs')->full('nav_aroslim_techspecs') !!}</li>

				<!--
				{{-- Enable Store --}}
				@if ($enableStore)  
					<li<?php echo ($__env->yieldContent('currentSubNav') == 3 ? ' class="active"' : ''); ?>><a href="/store">{!! $translate->token('nav_aroslim_buynow') !!}</a></li>
				@endif
				-->

				
			</ul>
		</div>
	</div>
</div>
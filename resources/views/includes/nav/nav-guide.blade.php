<div id="nav-secondary" class="navigation">
	<div class="nav-dropdown">
		<div class="container">
			<ul class="nav-list">
				<li>
					<a href="{!! $link->create('/styleguide')->url() !!}" id="dropdown-nav-button">
						<span id="dropdown-nav-button-icon"></span>
						{!! $link->create('/styleguide')->name() !!}
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="nav-sub">
		<div class="container">
			<ul class="nav-list">
				<li<?php echo ($__env->yieldContent('currentSubNav') == 1 ? ' class="active"' : ''); ?>><a href="/styleguide">Overview</a></li>
				<li<?php echo ($__env->yieldContent('currentSubNav') == 2 ? ' class="active"' : ''); ?>><a href="/styleguide/grids">Grids</a></li>
				<li<?php echo ($__env->yieldContent('currentSubNav') == 3 ? ' class="active"' : ''); ?>><a href="/styleguide/icons">Icons</a></li>
				<li<?php echo ($__env->yieldContent('currentSubNav') == 4 ? ' class="active"' : ''); ?>><a href="/styleguide/ui">UI</a></li>
			</ul>
		</div>
	</div>
</div>
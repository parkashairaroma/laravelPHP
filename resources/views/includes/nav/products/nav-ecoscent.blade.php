<div id="nav-secondary" class="navigation">
	<div class="nav-dropdown">
		<div class="container">
			<ul class="nav-list">
				<li>
					<a href="{{ $link->create('/ecoscent')->url() }}" id="dropdown-nav-button">
						<span id="dropdown-nav-button-icon"></span>
						{!! $link->create('/ecoscent')->name('nav_ecoscent') !!}
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="nav-sub">
		<div class="container">
			<ul class="nav-list">
				<li<?php echo ($__env->yieldContent('currentSubNav') == 1 ? ' class="active"' : ''); ?>>{!! $link->create('/ecoscent')->full('nav_ecoscent_overview') !!}</li>
				<li<?php echo ($__env->yieldContent('currentSubNav') == 2 ? ' class="active"' : ''); ?>>{!! $link->create('/ecoscent/techspecs')->full('nav_ecoscent_techspecs') !!}</li>
			</ul>
		</div>
	</div>
</div>
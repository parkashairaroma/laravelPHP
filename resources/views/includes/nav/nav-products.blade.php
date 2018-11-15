<div id="nav-secondary" class="navigation">
	<div class="nav-dropdown">
		<div class="container">
			<ul class="nav-list">
				<li>
					<a href="{!! $link->create('/products')->url() !!}" id="dropdown-nav-button">
						<span id="dropdown-nav-button-icon"></span>
						{!! $link->create('/products')->name('nav_products') !!}
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="nav-sub">
		<div class="container">
			<ul class="nav-list">
				<li<?php echo ($__env->yieldContent('currentSubNav') == 1 ? ' class="active"' : ''); ?>>{!! $link->create('/diffusers')->full('nav_products_diffusers') !!}</li>
				<li<?php echo ($__env->yieldContent('currentSubNav') == 2 ? ' class="active"' : ''); ?>>{!! $link->create('/signature-scent')->full('nav_products_signaturescent') !!}</li>
				<li<?php echo ($__env->yieldContent('currentSubNav') == 3 ? ' class="active"' : ''); ?>>{!! $link->create('/scents')->full('nav_products_scents') !!}</li>
				<li<?php echo ($__env->yieldContent('currentSubNav') == 4 ? ' class="active"' : ''); ?>>{!! $link->create('/aropromo')->full('nav_products_aropromo') !!}</li>
			</ul>
		</div>
	</div>
</div>
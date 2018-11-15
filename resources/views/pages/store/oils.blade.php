@section('bodyClass', 'store oils subnav')
@section('currentNav', 6)
@section('currentSubNav', $currentSubNav)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-store')

<div class="container">

	<div class="content-block">
		
		<div class="text-block">
			<h3>{{ $pageName }}</h3>
			@if (count($oilgroups))
				<div class="product-filter">
					<select class="fluid" id="oilgroup-select">

						@if ($group)
							<option value="/store/{{ $categorySlug }}">Remove Filter</option>
						@else
							<option value="/store/{{ $categorySlug }}">Filter By Group</option>
						@endif

						@foreach ($oilgroups as $slug => $name)
							@if ($group == $slug)
								<option value="/store/{{ $categorySlug }}/group/{{ $slug }}" selected>{{ $name }}</option>
							@else 
								<option value="/store/{{ $categorySlug }}/group/{{ $slug }}">{{ $name }}</option>
							@endif
						@endforeach
						
					</select>
				</div>
			@endif
		</div>
	</div>
	<div class="content-block">
		
		<div class="grid square large gutter">
		@foreach ($products as $prod)
			@include('pages.store.partials.product-tile')
		@endforeach
		</div>
	</div>
</div>

<script>

$(function() {
	$('.store').on('change', '#oilgroup-select', function() {

		var oilgroup = $(this).val();
		location.href=oilgroup;
	});
});

</script>
@stop
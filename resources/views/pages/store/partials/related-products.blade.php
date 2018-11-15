@inject('productService', 'AirAroma\Service\Store\ProductService')

<?php $relatedProducts = $productService->getRelatedProducts(2, $product['id']) ?>

@if ( $relatedProducts )
<div class="content-block">
	<div class="text-block tb-a">
		<h3>Customers also bought</h3>
	</div>
	<div class="grid square large gutter">
		@foreach ($relatedProducts as $prod)
			@include('pages.store.partials.product-tile')
		@endforeach
	</div>
</div>
@endif
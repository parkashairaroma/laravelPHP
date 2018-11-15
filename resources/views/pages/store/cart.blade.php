@section('bodyClass', 'store aromax subnav')
@section('currentNav', 6)
@section('currentSubNav', 0)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-store')

<div class="container">
	
	<div class="content-block">
		
		<div class="text-block">
			<h2>Your Shopping Cart</h2>
		</div>
		
		<div class="shopping-cart">
			
			<!-- Cart Header -->
			<div class="cart-row cart-header">
				<div class="cart-item">
					<div class="cart-item-image"></div>
					<div class="cart-item-desc">Item</div>
					<div class="cart-item-aux">
						<div class="cart-item-qty">Quantity</div>
						<div class="cart-item-price">Price</div>
					</div>
					<div class="cart-item-remove"></div>
				</div>
			</div>
			
			@if ($cartProductCount) 

				@foreach ($products as $product)
					<div class="cart-row cart-row-product" data-prvid="{{ $product['id'] }}" data-price="{{ $product['price'] }}">
						<div class="cart-item">
							<div class="cart-item-image">
								<a href="/store{{ $product['link'] }}"><img src="{{ $product['tile'] }}" alt="Product Image"></a>
							</div>
							<div class="cart-item-desc">
								<a href="/store{{ $product['link'] }}">{{ $product['name'] }} {{ $product['unit']['name'] }} {{ $product['colour']['name'] }}</a>
							</div>
							<div class="cart-item-aux">
								<div class="cart-item-qty">
                                    <input type="text" value="{{ $sessionCart[$product['id']]['quantity'] }}" class="ui-text" maxlength="2"/>
								</div>
								<div class="cart-item-price">
									{{ $siteConfig['cur_symbol'] }}<span id="price">{{ number_format($product['price']*$sessionCart[$product['id']]['quantity'], 2) }}</span>
								</div>
							</div>
						</div>
						<div class="cart-item-remove"><a href="javascript:void(0)" class="btn-remove"></a></div>
					</div>
				@endforeach
			@else

				<div class="cart-row cart-row-product">
					Your cart is currently empty.
				</div>

			@endif

			<!-- Cart Totals -->
			<div class="cart-row cart-total">
				<div class="cart-item">
					<dl class="cart-sub-total main-total">
						<dt class="cart-total-label">Sub total</dt>
						<dd class="cart-total-price">{{ $siteConfig['cur_symbol'] }}<span id="subtotal">{{ number_format($subtotal, 2) }}</span></dd>
					</dl>
				</div>
			</div>
			
			<!-- Cart Submit -->
			<div class="cart-submit">
				<div class="text-block tb-a">
					<div class="form-action">
					<div class="button-group">
						@if ($cartProductCount)
							<a href="/store/checkout" class="ui-button checkout-button"><span class="button-icon button-icon-lock"></span>Checkout</a>
						@else
							<a herf="#" class="ui-button button-disabled checkout-button" disabled><span class="button-icon button-icon-lock"></span>Checkout</a>
						@endif
						<a href="/store" class="ui-button continueshopping-button">Continue Shopping</a>
					</div>
						<p class="note"><small>Shipping and pickup options can be selected in Checkout.</small></p>
					</div>
				</div>
			</div>
			
		</div>

	</div>
	
</div>

<script>
$(function() {
    $('.cart-row-product').each(function () {
        var row = $(this);
        updatePrice(row);
        updateSubtotal();
    });

    $('.store')
    .on('keyup paste', '.cart-item-qty > input', function () {
        var row = $(this).parents('.cart-row-product');
        updatePrice(row);
        updateSubtotal();
        updateCart(row);
    })
    .on('click', '.cart-item-remove > a', function() {
        var row = $(this).parents('.cart-row-product');
        removeProduct(row);
    });
});

function removeProduct(row) {
    var prvId = row.data('prvid');

    api('get', '/ajax/store/cart/' + prvId).done(function (response) {

        if (response.products == 0) {
            $('.checkout-button').addClass('button-disabled').prop('disabled', 'disabled').removeAttr('href');
        }

        $('#store-count').text(response.products);

        row.fadeOut('slow', function() {
            row.remove();
            if(response.products == 0) {
                $('div.cart-row.cart-total').before(
                    $('<div>')
                        .addClass('cart-row')
                        .addClass('cart-row-product')
                        .addClass('cart-empty')
                        .html('Your cart is currently empty.')
                );
                $('div#cart-button').removeClass('has-item');
            }
            updateSubtotal();
        });
    });
}

function updateCart(row) {
    debugger;
    var prvId = row.data('prvid');
    var quantity = row.find('.cart-item-qty > input').val();
    var data = {
        'prvId': prvId,
        'quantity': quantity,
    };

    if (quantity == '0' || quantity == '' || isNaN(quantity)) {
        removeProduct(row);
    }
    else {
        api('put', '/ajax/store/cart', data).done(function (response) {
            $('#store-count').text(response.products);
        });
    }
}

function updatePrice(row) {
    var quantity = row.find('.cart-item-qty > input').val();
    var price = row.data('price');
    row.find('#price').text(parseFloat(price * quantity).toFixed(2));
}

function updateSubtotal() {
	var subtotal = 0;
    $('.cart-row-product').each(function () {
    	subtotal += parseFloat($(this).find('#price').text()) || 0;
    });

	subtotal = parseFloat(subtotal).toFixed(2);
    $('.store').find('#subtotal').text(subtotal);
}

</script>

@stop
@section('bodyClass', 'store subnav')
@section('currentNav', 6)
@section('currentSubNav', 0)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-store')

<div class="container">
	<div class="content-block">
		{!! Form::open(['method' => 'post', 'id' => 'form']) !!} 
		<div class="grid large input-grid ig-a">
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<h3>Shipping Address 
							@if ($addressbookcount > 0)
								<a href="#" class="edit-button shipping-addressbook">Address Book</a>
							@else
								<a href="#" class="edit-button shipping-edit @if (! session()->get('checkout.address.shipping.country_id') ) force-shipping-edit @endif">Edit</a>
							@endif
						</h3>
						<div>
							@include('pages.store.partials.addresses', ['type' => 'shipping'])

    @if ($shippingRestrict == false && $addressbookcount > 0 && $shippingserviceError == false)        
							@if (isset($shippingServices))								
									@if (count($shippingServices))
									<ul class="option-list">
										@foreach ($shippingServices as $shippingService)
											<li><input type="radio" name="shippingService" id="{{ $shippingService['code'] }}" class="ui-radio" @if ($shippingService['code'] == $shippingServiceSelected) checked="true" @endif><label for="delivery-method-{{ $shippingService['code'] }}">{{ $shippingService['name'] }}</label></li>
										@endforeach
									</ul>
									@else
										<div id="shipping-address-fault" class="error">
											<span class="message">We're having trouble calculating shipping to your address</span>
										</div>
									@endif
							@endif
						@endif

     @if ($errors->has("stripe_payment_error"))
          <div id="shipping-address-fault" class="error">
              <span class="message">{{ $errors->first('stripe_payment_error') }}</span>
          </div>
    @endif
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
                        <h3>
                            Billing Address
                            @if ($addressbookcount > 0)
                            <a href="#" class="edit-button billing-addressbook">Address Book</a>
                            @else
                            <a href="#" class="edit-button billing-edit">Edit</a>
                            @endif
                        </h3>
						<div>
							@include('pages.store.partials.addresses', ['type' => 'billing'])
						</div>
					</div>
				</div>
			</div>
		</div>

		@if ($shippingRestrict == true && $addressbookcount > 0 && $shippingserviceError == false)
			<div class="shipping-note">
				@if (websiteId() == 1)
					<p>Unfortunately this store does not ship to this country. Please change the shipping country or visit <a href="https://www.air-aroma.com.au/store">Air Aroma Australia Store</a></p>
				@elseif (websiteId() == 4)
					<p>Unfortunately this store does not ship to this country. Please change the shipping country or visit <a href="https://www.air-aroma.com/store">Air Aroma USA Store</a></p>
				@else
					<p>Unfortunately this store does not ship to this country. Please change the shipping country</p>
				@endif
			</div>
		@elseif ($shippingserviceError == true)
			<div class="shipping-note">
				<p>Australia post is having trouble calculating shipping to your address, please check the address and try again.</p>
			</div>
		@endif

     

        @if (session()->get('checkout.address.is_business') === "1")
            <input type="hidden" id="is_businesshidden" name="is_businesshidden" value="1"/>
        @else
            <input type="hidden" id="is_businesshidden" name="is_businesshidden" value="0" />
        @endif

		@include('pages.store.partials.addresses-form', ['type' => 'shipping', 'page' => 'checkout'])
		@include('pages.store.partials.addresses-form', ['type' => 'billing', 'page' => 'checkout'])
        @include('pages.store.partials.addresses-form', ['type' => 'editaddress', 'page' => 'checkout'])
        @include('pages.store.partials.addresses-form', ['type' => 'newaddress', 'page' => 'checkout'])
        @include('pages.store.partials.addresses-book', ['type' => 'shipping'])
        @include('pages.store.partials.addresses-book', ['type' => 'billing'])

    @if ($shippingRestrict == false && $addressbookcount > 0)            
	
		<div class="payment-collapse">
			<div class="payment-header">
				<h3>Payment</h3>
				<div class="form-group">
					<ul class="option-list">
						<li>
							<input type="radio" name="payment-method" value="creditcard" id="payment-creditcard" class="ui-radio"  @if ($paymentMethod == 'creditcard') checked @endif>
							<label for="payment-cc">
								<span class="label-text">Credit Card</span>
								<span class="payment-icons">
									<span class="payment-icon payment-icon-mastercard" title="MasterCard"></span>
									<span class="payment-icon payment-icon-visa" title="VISA"></span>
									<span class="payment-icon payment-icon-amex" title="American Express"></span>
									<span class="payment-icon payment-icon-diners" title="Diners Club"></span>
								</span>
							</label>
						</li>
						<li>
							<input type="radio" name="payment-method" value="paypal" id="payment-paypal" class="ui-radio" @if ($paymentMethod == 'paypal') checked @endif>
							<label for="payment-paypal"><span class="payment-icons"><span class="payment-icon payment-icon-paypal" title="PayPal"></span></span></label>
						</li>
         <li>
             <input type="radio" name="payment-method" value="AppleGooglePay" id="payment-applegooglepay" class="ui-radio" style="display:none;"> <label for="payment-paypal"><span class="payment-icons"><span class="" id="payment-applegooglepaytext"></span></span></label>
         </li>
					</ul>
				</div>
			</div>
			
            <div class="payment-tab" id="payment-tab-paypal" @if ($paymentMethod !='paypal' ) style="display: none" @endif>
                <div class="grid large input-grid ig-a">
                    <p>
                        PayPal is a fast, easy, and secure way to make payment securely online with a credit card or bank account.
                    </p>
                    <p>
                        Upon clicking 'Place Order' you will be taken to a secure PayPal page where you can enter your payment details. Once PayPal payment is complete, you will be returned to the Air Aroma website.
                    </p>
                </div>
                
            </div>

      <div class="payment-tab" id="payment-tab-applegooglepay" @if ($paymentMethod !='GooglePay' && $paymentMethod !='ApplePay' ) style="display: none" @endif>
          <div class="grid large input-grid ig-a">
              &nbsp;
          </div>
      </div>

			<div class="payment-tab" id="payment-tab-creditcard" @if ($paymentMethod != 'creditcard') style="display: none" @endif >

				<div class="grid large input-grid ig-a">
					<div class="box">
						<div class="box-cell">
							<div class="box-content">
								<div class="form-group @if ($errors->has("card_type")) error @endif">
									<label for="card-type">Card Type {!! $errors->first("card_type", '<span class="message">:message</span>') !!}</label>
									{{ Form::select('card_type', [
										'' => '', 
										'visa' => 'Visa', 
										'mastercard' => 'Master Card',
										'amex' => 'American Express',
										'dinersclubs' => 'Diners Club'
									], null, ['id' => 'card-type', 'class' => 'fluid']) }}
								</div>
							</div>
						</div>
					</div>
					<div class="box">
						<div class="box-cell">
							<div class="box-content">
								<div class="form-group @if ($errors->has("card_name")) error @endif">
									<label for="card-name">Name on Card {!! $errors->first("card_name", '<span class="message">:message</span>') !!}</label>
									{{ Form::text('card_name', null, ['id' => 'card-name', 'class' => 'ui-text']) }}
								</div>
							</div>
						</div>
					</div>
					<div class="box">
						<div class="box-cell">
							<div class="box-content">
								<div class="form-group @if ($errors->has("card_number")) error @endif">
									<label for="card-number">Card Number {!! $errors->first("card_number", '<span class="message">:message</span>') !!}</label>
									{{ Form::text('card_number', null, ['id' => 'card-number', 'class' => 'ui-text']) }}
								</div>
							</div>
						</div>
					</div>
					<div class="box">
						<div class="box-cell">
							<div class="box-content">
								<div class="form-group @if ($errors->has("card_date") || $errors->has("card_expiry_month") || $errors->has("card_expiry_year")) error @endif">
									<label for="card-expiry-month">Expiry Date @if ($errors->has("card_expiry_month") || $errors->has("card_expiry_year")) <span class="message">Date is required</span> @endif {!! $errors->first("card_date", '<span class="message">:message</span>') !!}</label>
									{{ Form::select('card_expiry_month', [''=>'']+$months, null, ['id' => 'card-expiry-month', 'class' => 'compact half']) }}
									{{ Form::select('card_expiry_year', [''=>'']+$years, null, ['id' => 'card-expiry-year', 'class' => 'compact half']) }}
								</div>
							</div>
						</div>
					</div>
					<div class="box">
						<div class="box-cell">
							<div class="box-content">
								<div class="form-group @if ($errors->has("card_security")) error @endif">
									<label for="card-security">CCV {!! $errors->first("card_security", '<span class="message">:message</span>') !!}</label>
									{{ Form::text('card_security', null, ['id' => 'card-security', 'class' => 'ui-text']) }}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="voucher-collapse">
            <div class="grid large input-grid ig-a">
                <div class="box">
                    <div class="box-cell">
                        <div class="box-content">
                            <div class="form-group success voucher-code @if ($errors->has(" voucher_code")) error @endif">
                                <label for="voucher-code">
                                    Voucher code {!! $errors->first("voucher_code", '<span class="message">:message</span>') !!}
                                    <span class="voucher-message">{{ session()->get('checkout.voucher.message') }}</span>
                                </label>
                                <div class="voucher-field">
                                	{{ Form::text('voucher_code', session()->get('checkout.voucher.code'), ['id' => 'voucher-code', 'class' => 'ui-text', 'data-current' => session()->get('checkout.voucher.code')]) }}
									<button class="ui-button button-disabled apply-voucher-code">Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

		<div class="shopping-cart cart-summary cart-collapse">
			
			<div class="summary-header">
				<h3>Order Summary <a href="/store/cart" class="edit-button">Edit Cart</a></h3>
			</div>

			@if ($cartProductCount) 
				@foreach (session()->get('checkout.products') as $product)
					<div class="cart-row cart-row-product" data-prvid="{{ $product['id'] }}" data-price="{{ $product['price'] }}">
						<div class="cart-item">
							<div class="cart-item-desc"><a href="/store/{{ $product['link'] }}">{{ $product['name'] }} {{ $product['unit']['name'] }} {{ $product['colour']['name'] }}</a></div>
							<div class="cart-item-aux">
								<div class="cart-item-single-amount">{{ $siteConfig['cur_symbol'] }}<span id="price">{{ $product['price'] }}</span></div>
								<div class="cart-item-qty">{{ $cart[$product['id']]['quantity'] }}</div>
								<div class="cart-item-price">{{ $siteConfig['cur_symbol'] }}<span id="price">{{ number_format($product['price']*$cart[$product['id']]['quantity'], 2) }}</span></div>
							</div>
						</div>
					</div>
				@endforeach
			@endif
						
			<div class="cart-row cart-total">
				<div class="cart-item">
					<dl class="cart-sub-total">
						<dt class="cart-total-label">Subtotal</dt>
						<dd class="cart-total-price"><span id="currency">{{ $siteConfig['cur_symbol'] }}</span><span id="subtotal">{{ session()->get('checkout.charges.subtotal') }}</span></dd>
					</dl>
					
					<dl class="cart-sub-total">
						<dt class="cart-total-label">Shipping</dt>
						<dd class="cart-total-price">{{ $siteConfig['cur_symbol'] }}<span id="shipping">{{ session()->get('checkout.charges.shipping') }}</span></dd>
					</dl>
					<dl class="cart-sub-total">
						<dt class="cart-total-label">Tax</dt>
						<dd class="cart-total-price">{{ $siteConfig['cur_symbol'] }}<span id="tax">{{ session()->get('checkout.charges.tax') }}</span></dd>
					</dl>

        @if (session()->get('checkout.voucher.percent') || session()->get('checkout.voucher.dollars'))
        <dl class="cart-sub-total voucher">
            <dt class="cart-total-label">Discount</dt>
            <dd class="cart-total-price">-{{ $siteConfig['cur_symbol'] }}<span id="discount">{{ session()->get('checkout.charges.discount') }}</span></dd>
        </dl>
        @endif

					<dl class="cart-sub-total main-total">
						<dt class="cart-total-label">Order Total</dt>
						<dd class="cart-total-price">{{ $siteConfig['cur_symbol'] }}<span id="total">{{ session()->get('checkout.charges.total') }}</span></dd>
					</dl>
				</div>
    <input type="hidden" id="staCodeHolder" />
			</div>
			<div class="cart-submit">
				<div class="text-block tb-a">
					<div class="form-action">
						@if ($cartProductCount && session()->get('checkout.address.complete') && count($shippingServices))
							<button class="ui-button place-order checkout-button"><span class="button-icon button-icon-lock"></span>Place order</button>
         <div id="payment-request-button" style="display:none;">
             <!-- A Stripe Element will be inserted here. -->
         </div>
						@else
							<button class="ui-button place-order button-disabled checkout-button" disabled><span class="button-icon button-icon-lock"></span>Place order</button>
         <div id="payment-request-button" style="display:none;">
             <!-- A Stripe Element will be inserted here. -->
         </div>
						@endif
						<p class="note"><small>By clicking Place Order, you accept and agree to all of Air Aroma's Terms and Conditions and Orders and Returns Policy, all Air Aroma Product Terms and Conditions. You understand that an invoice that will be provided to you electronically contains an itemized list of your purchase, including shipping charges.</small></p>
					</div>
				</div>
			</div>
		</div>
                        
    @endif                                     
</div>

    <script>
$(function() {

    var shipping = $('.shipping-address-form');
	var billing = $('.billing-address-form');
    var editaddress = $('.editaddress-address-form');
    var newaddress = $('.newaddress-address-form');
    var shippingaddressbook = $('.shipping-address-book');
    var billingaddressbook = $('.billing-address-book');

    $( document ).ready(function() {
    @if ($editaddressectionflag == 1)
            showAddressEditor(editaddress, shipping, newaddress, billing, $(this));
    @endif

    @if (Session::has('addressBookRetunType'))
        @if (Session::get('addressBookRetunType') == 'shipping')
            showAddressBookEditor(shippingaddressbook, billingaddressbook, $(this));
        @elseif (Session::get('addressBookRetunType') == 'billing')
            showAddressBookEditor(billingaddressbook, shippingaddressbook, $(this));
        @endif
    @endif

    @if ($errors)
		var type = '{{ $errors->first('type') }}';
        debugger;
        if (type == 'newaddress')
        {
            $('.{{ $errors->first('addressbookFormtype') }}').show();
            $('.address-book-style').hide();
            $('.useaddress-shipping-button').hide();
            $('.useaddress-billing-button').hide();
            $('.newaddress-edit').show();
            $('.newaddress-edit').html('Cancel');

            if($('.voucher-collapse').is(':visible')) {
			    $('.voucher-collapse').hide();
		    }
		    if($('.payment-collapse').is(':visible')) {
			    $('.payment-collapse').hide();
		    }
		    if($('.cart-collapse').is(':visible')) {
			    $('.cart-collapse').hide();
		    }
            $('.' + type + '-address-form').slideToggle('fast');
        }
        else if (type == 'editaddress')
        {
            $('.editaddress-edit').show();
            $('.editaddress-edit').slideToggle('fast');
        }
        else
        {
            //$('.' + type + '-address-form').show();
            //$('.' + type + '-address-form').slideToggle('fast');
        }
	@endif
});

	$('.store')
	.on('click', '#payment-creditcard', function() {
		$('#payment-tab-paypal').hide();
		$('#payment-tab-creditcard').show();
    $('#payment-tab-applegooglepay').hide();
    $('.checkout-button').show();
    $('#payment-request-button').hide();
	})
	.on('click', '#payment-paypal', function() {
		$('#payment-tab-paypal').show();
    $('#payment-tab-creditcard').hide();
     $('#payment-tab-applegooglepay').hide();
    $('.checkout-button').show();
    $('#payment-request-button').hide();
	})
    .on('click', '#payment-applegooglepay', function() {
		$('#payment-tab-applegooglepay').show();
		$('#payment-tab-creditcard').hide();
    $('#payment-tab-paypal').hide();
    $('.checkout-button').hide();
    $('#payment-request-button').show();
	})
	.on('click', '.shipping-edit', function() {
		showAddressEditor(shipping, billing, newaddress, editaddress, $(this));
	})
	.on('click', '.billing-edit', function() {
		showAddressEditor(billing, shipping, newaddress, editaddress, $(this));
	})
    .on('click', '.editaddress-edit', function() {
    alert(1);
		showAddressEditor(editaddress, shipping, newaddress, billing, $(this));
	})
    .on('click', '.newaddress-edit', function() {
    if ($('.shipping-address-book').is(':visible'))
    {
       $('#form').append('<input type="hidden" name="newaddress_type" value="shipping">');
    }
    else if ($('.billing-address-book').is(':visible'))
    {
        $('#form').append('<input type="hidden" name="newaddress_type" value="billing">');
    }
    $('.shipping-addressbook').hide();
    $('.billing-addressbook').hide();
		showAddressEditor(newaddress, billing, shipping, editaddress, $(this));
  $select = $('select[name="address[newaddress][state_id]"]');
		$select.find('option:selected').removeAttr('selected');
		$select.dropdown('clear');
		$select.find('option:eq(1)').prop('selected', true);
		$select.dropdown('set selected', $('select[name="address[newaddress][state_id]"] option:selected').eq(0).val());
		$select.dropdown('set text', $('select[name="address[newaddress][state_id]"] option:selected').eq(0).html());

	})
    .on('click', '.shipping-addressbook', function() {
		showAddressBookEditor(shippingaddressbook, billingaddressbook, $(this));
	})
    .on('click', '.billing-addressbook', function() {
		showAddressBookEditor(billingaddressbook, shippingaddressbook, $(this));
	})
	.on('change', '.shipping-address-form #country_id', function() {
		var countryId = $(this).val();
		shipping.find('#state_id').dropdown('clear');
		populateStates(shipping, countryId, 'shipping');
		togglePostcodeSearch('shipping');
	})
	.on('change', '.billing-address-form #country_id', function() {
		var countryId = $(this).val();
		billing.find('#state_id').dropdown('clear');
		populateStates(billing, countryId, 'billing');
		togglePostcodeSearch('billing');
	})
    .on('change', '.editaddress-address-form #country_id', function() {
		var countryId = $(this).val();
		editaddress.find('#state_id').dropdown('clear');
		populateStates(editaddress, countryId, 'editaddress');
		togglePostcodeSearch('editaddress');
	})
	.on('change', '.shipping-address-form #state_id', function() {
		var stateId = $(this).val();
		shipping.find('#county_id').dropdown('clear');
		populateCounties(shipping, stateId, 'shipping');
	})
	.on('change', '.billing-address-form #state_id', function() {
		var stateId = $(this).val();
		billing.find('#state_id').dropdown('clear');
		populateStates(billing, countryId, 'billing');
	})
    .on('change', '.editaddress-address-form #state_id', function() {
		var stateId = $(this).val();
		editaddress.find('#county_id').dropdown('clear');
		populateCounties(editaddress, stateId, 'editaddress');
	})
    .on('change', '.newaddress-address-form #country_id', function() {
		var countryId = $(this).val();
		newaddress.find('#state_id').dropdown('clear');
		populateStates(newaddress, countryId, 'newaddress');
		togglePostcodeSearch('newaddress');
	})
    .on('change', '.newaddress-address-form #state_id', function() {
		var stateId = $(this).val();
		newaddress.find('#county_id').dropdown('clear');
		populateCounties(newaddress, stateId, 'newaddress');
	})
	.on('change', 'input[type="radio"][name="shippingService"]', function(){
		api('get', '/ajax/store/cart/shipping/' + $(this).attr('id')).done(function (response) {
			$('#shipping').text(parseFloat(response.shippingcost).toFixed(2));
			updateTax();
			updateTotal();
		});
	})
	.on('click', '.save-shipping-address', function() {
		$('#form').append('<input type="hidden" name="form_type" value="shipping">');
	})
    .on('click', '.save-editaddress-address', function() {
		$('#form').append('<input type="hidden" name="form_type" value="editaddress">');
	})
	.on('click', '.save-billing-address', function() {
		$('#form').append('<input type="hidden" name="form_type" value="billing">');
	})
    .on('click', '.save-newaddress-address', function() {
		$('#form').append('<input type="hidden" name="form_type" value="newaddress">');
	})
    .on('click', '.edit-button-addressbook', function() {

        $('#editadd_id').val($(this).attr('id'));
		      $('#form').append('<input type="hidden" name="form_type" value="edit-addressbook">');
        $('#form').submit();
	})
    .on('click', '.useaddress-shipping-button', function() {
		$('#form').append('<input type="hidden" name="form_type" value="useaddress-shipping">');
	})
    .on('click', '.useaddress-billing-button', function() {
		$('#form').append('<input type="hidden" name="form_type" value="useaddress-billing">');
	})
	.on('click', '.cancel-billing-address, .cancel-shipping-address', function() {
		closeAddressEditor();
		return false;
	})
    .on('click', '.cancel-editaddress-address, .cancel-shipping-address', function() {
		$('#form').append('<input type="hidden" name="form_type" value="editaddress-cancel">');
	})
	.on('keyup', '#voucher-code', function() {
		if($(this).val() == $(this).data('current')) {
			$('.apply-voucher-code').addClass('button-disabled');
		}
		else {
			$('.apply-voucher-code').removeClass('button-disabled');
		}
	})
	.on('click', '.apply-voucher-code', function() {
		$('#form').append('<input type="hidden" name="form_type" value="voucher">');
	})
	.on('click', '.place-order', function() {
		$('#form').append('<input type="hidden" name="form_type" value="order">');
	});

	setupPostcodeSearch();

	$('.edit-button.shipping-edit.force-shipping-edit').click();

    //$(".shipping-address-form").on('change','select',function () { alert('hello'); });

});

function showAddressEditor(showform, hideform, hideform2, hideform3, button) {
	if(showform.is(':visible')) {
        if (showform.attr('class').indexOf("newaddress") >= 0)
        {
            closeAddressEditor('newaddress');
        }
        else if (showform.attr('class').indexOf("editaddress") >= 0)
        {
            closeAddressEditor('editaddress');
        }
        else
        {
            closeAddressEditor();
        }

	}
	else {
        if (showform.attr('class').indexOf("newaddress") >= 0)
        {
            $('.newaddress-edit').html('Add a new address');
            button.html('Cancel');
            $('.shipping-address-book').css("display","none");
            $('.billing-address-book').css("display","none");
            $('.useaddress-shipping-button').hide();
            $('.useaddress-billing-button').hide();
            $('.address-book-style').hide();
        }
        else
        {
            $('.shipping-edit, .billing-edit').html('Edit');
		          button.html('Cancel');
        }
		showform.show();

		if( hideform.is(':visible')) {
			hideform.hide();
		}
        if( hideform2.is(':visible')) {
			hideform2.hide();
		}
        if( hideform3.is(':visible')) {
			hideform3.hide();
		}
		if($('.voucher-collapse').is(':visible')) {
			$('.voucher-collapse').hide();
		}
		if($('.payment-collapse').is(':visible')) {
			$('.payment-collapse').hide();
		}
		if($('.cart-collapse').is(':visible')) {
			$('.cart-collapse').hide();
		}

		scrollToElement(showform);
	}
}

function showAddressBookEditor(showform, hideform, button) {
	if(showform.is(':visible')) {
		//closeAddressEditor();         //Will do Soon
	}
	else {
		//$('.shipping-edit, .billing-edit').html('Edit');
		//button.html('Cancel');
		showform.show();

		if( hideform.is(':visible')) {
			hideform.hide();
		}
		if($('.voucher-collapse').is(':visible')) {
			$('.voucher-collapse').hide();
		}
		if($('.payment-collapse').is(':visible')) {
			$('.payment-collapse').hide();
		}
		if($('.cart-collapse').is(':visible')) {
			$('.cart-collapse').hide();
		}

		scrollToElement(showform);
	}
}

function closeAddressEditor(menu) {
    if (menu != null)       // For Address Book
    {
        $('.newaddress-edit').html('Add a new address');

        $('.useaddress-shipping-button').show();
        $('.useaddress-billing-button').show();
        $('.address-book-style').show();

        if($('.shipping-address-form').is(':visible')) {
		    $('.shipping-address-form').hide();
	    }
	    if($('.billing-address-form').is(':visible')) {
		    $('.billing-address-form').hide();
	    }
        if($('.newaddress-address-form').is(':visible')) {
		    $('.newaddress-address-form').hide();
	    }
    }
    else
    {
    $('.shipping-edit, .billing-edit').html('Edit');
	if($('.shipping-address-form').is(':visible')) {
		$('.shipping-address-form').hide();
	}
	if($('.billing-address-form').is(':visible')) {
		$('.billing-address-form').hide();
	}
    if($('.newaddress-address-form').is(':visible')) {
		$('.newaddress-address-form').hide();
	}
	if($('.voucher-collapse').is(':hidden')) {
		$('.voucher-collapse').show();
	}
	if($('.payment-collapse').is(':hidden')) {
		$('.payment-collapse').show();
	}
	if($('.cart-collapse').is(':hidden')) {
		$('.cart-collapse').show();
	}
    }

}

function setupPostcodeSearch() {
	togglePostcodeSearch('shipping');
	togglePostcodeSearch('billing');
}

function togglePostcodeSearch(type) {
	var $country = $('.'+type+'-address-form #country_id');
	var $postcode = $('.'+type+'-address-form .postcode-search');

	countryId = $country.val();
	if(countryId == 192) {
		$postcode.search({
			apiSettings: {
					url: '/ajax/store/address/postcode/AU/{query}'
				},
				minCharacters: 3,
				fields: {
					results: 'localities',
					title: 'postcode',
					description: 'city'
				},
				onSelect: function(data) {
					$('input[name="address['+type+'][city]"]').val(data['city']);
					$select = $('select[name="address['+type+'][state_id]"]');
					$select.find('option:selected').removeAttr('selected');
					$select.dropdown('clear');
					$select.find('option[data-code="'+data['state']+'"]').prop('selected', true);
					$select.dropdown('set selected', $('select[name="address['+type+'][state_id]"] option:selected').eq(0).val());
					$select.dropdown('set text', $('select[name="address['+type+'][state_id]"] option:selected').eq(0).html());
				}
			});
	}
	else
	{
		$postcode.search('destroy');
	}
}

function populateCounties(elem, countryId, type) {

	api('get', '/ajax/store/counties').done(function (response) {
		if ($.type(response[countryId]) == 'undefined') {
			elem.find('#county_id').empty();
			elem.find(".counties span").replaceWith('<span><input type="hidden" name="address['+type+'][county_id]" value="0" id="county_id" class="ui-text"></span>');
		} else {
			elem.find(".counties span").replaceWith('<span>County <select name="address['+type+'][county_id]" id="county_id" class="ui fluid search selection dropdown"></select></span>');
			elem.find('#county_id').dropdown();
			elem.find("#county_id").append('<option value=""></option>');
			$.each(response[countryId], function(key, value) {
				elem.find("#county_id").append('<option value="'+key+'">'+value+'</option>');
			});
		}
	});
}

function populateStates(elem, stateId, type) {

        debugger;
	api('get', '/ajax/store/states').done(function (response) {

		if ($.type(response[stateId]) == 'undefined') {
			elem.find('#state_id').empty();
			elem.find(".states span").replaceWith('<span><input type="text" name="address['+type+'][state_id]" id="state_id" class="ui-text"></span>');
		} else {
			elem.find(".states span").replaceWith('<span><select name="address['+type+'][state_id]" id="state_id" class="ui fluid search selection dropdown"></select></span>');
			elem.find('#state_id').dropdown();
			elem.find("#state_id").append('<option value=""></option>');
			$.each(response[stateId], function(key, value) {
      elem.find("#state_id").append('<option value="'+key+'" data-code="'+value['code']+'">'+value['name']+'</option>');
			});

		 $select = $('select[name="address['+type+'][state_id]"]');
			$select.find('option:selected').removeAttr('selected');
			$select.dropdown('clear');
			$select.find('option:eq(1)').prop('selected', true);
			$select.dropdown('set selected', $('select[name="address['+type+'][state_id]"] option:selected').eq(0).val());
			$select.dropdown('set text', $('select[name="address['+type+'][state_id]"] option:selected').eq(0).html());
		}
	});
}

function updateTax() {
	var goodstax = parseFloat('{{ session()->get('checkout.taxes.goodstax') }}');
	var shippingtax = parseFloat('{{ session()->get('checkout.taxes.shippingtax') }}');
	var countytax = parseFloat('{{ session()->get('checkout.taxes.countytax') }}');

	var discount = parseFloat($('#discount').text());
	var subtotal = parseFloat($('#subtotal').text());
	var shipping = parseFloat($('#shipping').text());

	if (isNaN(discount)) {
  		discount = parseFloat(0);
	}

	if (countytax) {
		var tax = ((subtotal - discount) / 100) * countytax;
	} else {
		if (goodstax && shippingtax) {
			var tax = (((subtotal - discount) / 100) * goodstax) + ((shipping / 100) * shippingtax);
		}
	}

 if (isNaN(tax))
 {
    $('#tax').text(parseFloat(0).toFixed(2));
 }
 else
 {
    $('#tax').text(parseFloat(tax).toFixed(2));
 }

}

function updateTotal() {

	var discount = parseFloat($('#discount').text());
	var subtotal = parseFloat($('#subtotal').text());
	var shipping = parseFloat($('#shipping').text());
	var tax = parseFloat($('#tax').text());

	if (isNaN(discount)) {
  		discount = parseFloat(0);
	}

	var total = (subtotal - discount) + shipping + tax;

	$('#total').text(parseFloat(total).toFixed(2));
}

    </script>

    <script src="https://js.stripe.com/v3/"></script>

    <script>

		@if (websiteId() == 4)
        	var stripe = Stripe('pk_live_uMyO7PrzeS4ce1HfveGD0aBK');
		@else
        	var stripe = Stripe('pk_live_7bVxs8akc4DYVpaLLKOBYvx5');
		@endif

        // Create the payment request.
  var paymentRequest = stripe.paymentRequest({
    country: 'US',
    currency: 'usd',
    total: {
      label: 'Total',
      amount: {{ session()->get('checkout.charges.total') }} * 100,
    }
  });

        var elements = stripe.elements();
var prButton = elements.create('paymentRequestButton', {
  paymentRequest: paymentRequest,
});

var paymentAppGoo = '';

// Check the availability of the Payment Request API first.
paymentRequest.canMakePayment().then(function(result) {
  if (result) {
    debugger;
    if (result.applePay == false)
    {
        $('#payment-applegooglepay').show();
        $('#payment-applegooglepay').val('GooglePay');
        $('#payment-applegooglepaytext').addClass('payment-icon');
        $('#payment-applegooglepaytext').addClass('payment-icon-googlepay');
    }
    else
    {
        $('#payment-applegooglepay').show();
        $('#payment-applegooglepay').val('ApplePay');
        $('#payment-applegooglepaytext').addClass('payment-icon');
        $('#payment-applegooglepaytext').addClass('payment-icon-applepay');
    }
    prButton.mount('#payment-request-button');
  } else {
    document.getElementById('payment-request-button').style.display = 'none';
        $('#payment-applegooglepay').hide();
        $('#payment-applegooglepaytext').hide();
  }
  });

  paymentRequest.on('token', function (ev) {
            debugger;
  // Send the token to your server to charge it!
  fetch('/store/applepaycharge', {
    method: 'POST',
    body: JSON.stringify({token: ev.token.id}),
  })
  .then(function(response) {
      if (response.ok) {
          $.post( "/store/checkout", { form_type: "order", 'payment-method': $('#payment-applegooglepay').val(), token: ev.token.id })
              .done(function (data) {
                  window.location.href = '/store/account/orders/' + data.order_id;
              })
              .error(function() { alert("error occured."); });
      // Report to the browser that the payment was successful, prompting
      // it to close the browser payment interface.
      ev.complete('success');
      } else {
      // Report to the browser that the payment failed, prompting it to
      // re-show the payment interface, or show an error message and close
      // the payment interface.
      ev.complete('fail');
    }
  });
        });


        paymentRequest.on('shippingaddresschange', function(ev) {
  if (ev.shippingAddress.country !== 'US') {
    ev.updateWith({status: 'invalid_shipping_address'});
  } else {
    // Perform server-side request to fetch shipping options
    fetch('/calculateShipping', {
      data: JSON.stringify({
        shippingAddress: ev.shippingAddress
      })
    }).then(function(response) {
      return response.json();
    }).then(function(result) {
      ev.updateWith({
        status: 'success',
        shippingOptions: result.supportedShippingOptions,
      });
    });
  }
});
    </script>
@stop
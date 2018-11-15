 @section('bodyClass', 'store-account-orders aromax subnav')
@section('currentNav', 6)
@section('currentSubNav', 0)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-store')

<div class="container">
	<div class="content-block">
		<div class="grid large input-grid ig-a">
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<h3>Shipping Address</h3>
						<div>
							<p>
								<span>{{ $order->ord_firstname }}</span>
								<span>{{ $order->ord_lastname }}</span><br>
								<span>{{ $order->ord_street }} {{ $order->ord_aptsuite }}</span><br>
								<span>{{ $order->ord_city }}</span>
								<span>{{ $order->ord_postcode }}</span><br>	
								<span>{{ isset($counties[$order->ord_state][$order->ord_county_id]) ? $counties[$order->ord_state][$order->ord_county_id] : null }}</span>
								<span>{{ isset($states[$order->ord_cou_id]) ? $states[$order->ord_cou_id][$order->ord_state]['name'] : $order->ord_state }}</span><br>
								<span>{{ isset($countries[$order->ord_cou_id]) ? $countries[$order->ord_cou_id] : $countries[$order->ord_cou_id] }}</span>
							</p>
							<p><span>Status: <span style="color: {{ $orderStatus['colours'][$order->ord_status] }}">{{ $orderStatus['names'][$order->ord_status] }}</span></span>
								@if ($order['ord_trackingnumber'])
								<br />
								<span>Tracking #: {{ $order->ord_trackingnumber }}</span>
								@endif
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<h3>Details</h3>
						<div>
					        <?php
					
					        $OrderNumber = "";
					        if($order->ord_website_id == 1)
					        {
					            $OrderNumber .= "AA";
					        }elseif($order->ord_website_id == 4)
					        {
					            $OrderNumber .= "AU";
					        }else {
					            $OrderNumber .= "WW";
					        }
					        $OrderNumber .= date("Ym", strtotime($order->ord_date));
					        $OrderNumber .= $order->ord_id;
					            
					           ?>
													<span>Order: {{ $OrderNumber }}</span><br>
													<span>Order Date: {{ date('d F Y', strtotime($order->ord_date)) }}</span><br>
													<span>Payment Type: {{ strtoupper($order['ord_paymenttype']) }}</span><br>
					        @if ($order['ord_vouchercode'])
													<span>Voucher: {{ $order->ord_vouchercode }}</span>
					        @endif
						</div>
					</div>
				</div>
			</div>
    
		</div>
			
		<div class="shopping-cart cart-summary">

			<div class="summary-header">
				<h3>Order Summary</h3>
			</div>

			@if ($order->count()) 
				@foreach ($order->products as $product)
					<div class="cart-row cart-row-product" data-prvid="{{ $product['prv_id'] }}" data-price="{{ $product['ordpro_price'] }}">
						<div class="cart-item">
							<div class="cart-item-desc">{{ $product['pro_name'] }} <?php if ($product['uni_size'] == 0) { echo ""; } else { echo $product['uni_name']; } ?> <?php if ($product['col_id'] == 1) { echo ""; } else { echo $product['col_name']; } ?></div>
        <div class="cart-item-qty">{{ $order['cur_symbol'] }}<span id="price">{{ $product['ordpro_price'] }}</span></div>
							<div class="cart-item-qty">{{ $product['ordpro_quantity'] }}</div>
							<div class="cart-item-price">{{ $order['cur_symbol'] }}<span id="price">{{ number_format($product['ordpro_price'] * $product['ordpro_quantity'], 2)  }}</span></div>
						</div>
					</div>
				@endforeach
			@endif

			<div class="cart-row cart-total">
				<div class="cart-item">
					<dl class="cart-sub-total">
						<dt class="cart-total-label">Subtotal</dt>
						<dd class="cart-total-price"><span id="currency">{{ $order['cur_symbol'] }}</span><span id="subtotal">{{ $order['ord_goodscost'] }}</span></dd>
					</dl>
					
					<dl class="cart-sub-total">
						<dt class="cart-total-label">Shipping</dt>
						<dd class="cart-total-price">{{ $order['cur_symbol'] }}<span id="shipping">{{ $order['ord_shippingcost'] }}</span></dd>
					</dl>
					<dl class="cart-sub-total">
						<dt class="cart-total-label">Tax</dt>
						<dd class="cart-total-price">{{ $order['cur_symbol'] }}<span id="tax">{{ $order['ord_taxincluded'] }}</span></dd>
					</dl>

    @if ($order['ord_vouchercode'])
						<dl class="cart-sub-total voucher">
							<dt class="cart-total-label">Discount</dt>
							<dd class="cart-total-price">-{{ $order['cur_symbol'] }}<span id="discount">{{ $order['ord_voucherdiscount'] }}</span></dd>
						</dl>
					@endif

					<dl class="cart-sub-total main-total">
						<dt class="cart-total-label">Order total</dt>
						<dd class="cart-total-price">{{ $order['cur_symbol'] }}<span id="total">{{ $order['ord_totalcost'] }}</span></dd>
					</dl>
				</div>

		        <div class="button-group">
		            <button class="ui-button" onclick="window.print();">Print invoice</button>
		        </div>
   
			</div>

		</div>

	</div>
</div>

@stop
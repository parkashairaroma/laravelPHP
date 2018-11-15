 @section('bodyClass', 'store-account-orders aromax subnav')
@section('currentNav', 6)
@section('currentSubNav', 0)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-store')

<div class="container">

	<div class="content-block">

		<h2>Order History</h2>

		<table>
			<tr>
				<th>Date</th>
				<th>Number</th>
				<th>Cost</th>
				<th>Status</th>
			</tr>
			@if ($orders->count())
				@foreach ($orders as $order)
					<tr>
						<td>{{ date('d F Y', strtotime($order->date)) }}</td>
						<td><a href="/store/account/orders/{{ $order->number }}">{{ $order->number }}</a></td>
						<td>{{ $siteConfig['cur_symbol'] }}{{ $order->cost }}</td>
						<td><span style="color: {{ $orderStatus['colours'][$order->status] }}">{{ $orderStatus['names'][$order->status] }}</span></td>
					</tr>
				@endforeach
			@else
				<tr>
					<td colspan="4">No Orders Found.</td>
				</tr>
			@endif
		</table>	
	</div>
</div>

@stop
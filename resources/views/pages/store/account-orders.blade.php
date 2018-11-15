 @section('bodyClass', 'store-account-orders aromax subnav')
@section('currentNav', 6)
@section('currentSubNav', 0)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-store')

<div class="container">

	<div class="content-block">

		<div class="text-block">
			<h2>Your Orders</h2>
		</div>
		
		<div class="order-history">
			<div class="history-row history-header">
				<div class="order-date">Date</div>
				<div class="order-number">Order Number</div>
				<div class="order-cost">Cost</div>
				<div class="order-status">Status</div>
			</div>
			@if ($orders->count())
				<?php
					$ordcount = 0;
					$ordnum = 0;
				?>
				@foreach ($orders as $order)
					<?php
						if (fmod($ordcount,6) == 0)
						{
							$ordnum++;
						}
					?>
					<div class="history-row history-row-order orderpage_<?php echo $ordnum; ?> orderpages" style="<?php if ($ordcount > 5) { echo 'display:none;' ; }?>">
						<div class="order-date">{{ date('d F Y', strtotime($order->date)) }}</div>
						<div class="order-number">
							<a href="/store/account/orders/{{ $order->number }}">
								<?php
									$OrderNumber = "";
									if($order->website_id == 1)
									{
										$OrderNumber .= "AA";
									} elseif($order->website_id == 4)
									{
										$OrderNumber .= "AU";
									}else {
										$OrderNumber .= "WW";
									}
									$OrderNumber .= date("Ym", strtotime($order->date));
									$OrderNumber .= $order->number;
								?>
								{{ $OrderNumber }}
							</a>
						</div>
						<div class="order-cost">{{ $order->currency_symbol}}{{ $order->total }}</div>
						<div class="order-status"><span style="color: {{ $orderStatus['colours'][$order->status] }}">{{ $orderStatus['names'][$order->status] }}</span></div>
					</div>
					<?php
						$ordcount++;
					?>
				@endforeach
			@else
				<div class="history-row history-row-order">No Orders Found.</div>
			@endif
		</div>
         <br />

         @if ($orders->count() > 6)<?php  $totalrecord = (int) $orders->count() / 6;
     $totalrecord =  ceil($totalrecord);
     ?>
     <br />
         <div class="order-paggination">
             <a href="#" style="text-decoration:none;" class="paginate_previous">Previous</a>
             &nbsp;
             <input type="text" class="ui-text paginate_1 selected orderspaginate" readonly="readonly" value="1" /><?php
         for ($x = 1; $x < $totalrecord; $x++) {
         ?>
             <input type="text" class="ui-text paginate_<?php echo $x+1; ?> orderspaginate" readonly="readonly" value="<?php echo $x+1; ?>" /><?php } ?>
             &nbsp;
             <a href="#" style="text-decoration:none;" class="paginate_next">Next</a>
         </div>
         <br />
         <br />
         @endif

     </div>
</div>

<script>
    $(function() {
        $( ".orderspaginate" ).click(function() {
            $(".orderpages").hide();
            $(".orderpage_" + $(this).val()).show();
            $(".orderspaginate").removeClass("selected");
            $(".paginate_"+ $(this).val()).addClass("selected");
        });

        $(".paginate_next").click(function () {
            selectedpage = $(".orderspaginate.selected").val();
            selectedpage++;
            if ($(".paginate_" + selectedpage)[0])
            {
                $(".paginate_" + selectedpage).click();
            }
        });

            $(".paginate_previous").click(function () {
            selectedpage = $(".orderspaginate.selected").val();
            selectedpage--;
            if ($(".paginate_" + selectedpage)[0])
            {
                $(".paginate_" + selectedpage).click();
            }
        });
}); 
</script>

@stop
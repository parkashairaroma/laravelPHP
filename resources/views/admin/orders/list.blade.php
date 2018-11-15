@extends('admin.layouts.control')

@section('content')

<section class="blogs page">
    <div class="actionbar">
        <div class="header">
            <h3>Order Notifications</h3>
        </div>
    </div>
    <table class="table" id="ordersTable">
        <thead>
            <tr>
                <th>Order Number</th>
                <th>Date & Time</th>
                <th>Name</th>
                <th>Country</th>
                <th>Status</th>
                <th>Value</th>
                <th class="actioncol">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr data-id="{{ $order->ord_id }}">
                <td>
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
                        echo $OrderNumber;
                    ?>
                </td>
                <td>
                    <span style="display:none;">
                    <?php echo date('YmdHis', strtotime($order->ord_date)); ?>
                    </span>
                    <?php echo date('d-m-Y H:i:s', strtotime($order->ord_date)); ?>
                </td>
                <td>{{ $order->ord_firstname . " " .$order->ord_lastname }}</td>
                <td>{{ $order->cou_name }}</td>
                <td>
                    <?php
                        if ($order->ord_status == 1)
                        {
                            echo "New";
                        }
                        if ($order->ord_status == 2)
                        {
                            echo "Processing";
                        }
                        if ($order->ord_status == 3)
                        {
                            echo "Cancelled";
                        }
                        if ($order->ord_status == 4)
                        {
                            echo "Shipped";
                        }
                        if ($order->ord_status == 5)
                        {
                            echo "Draft";
                        }
                    ?>
                </td>
                <td> {{$order->cur_symbol . $order->ord_totalcost}} </td>
                <td class="actioncol">
                    <a href="orders/edit/{{    $order->ord_id }}" type="button" class="btn btn-success btn-sm">
                        <i class="fa fa-eye tip" title="View"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>

<script>
    $(document).ready(function () {
        $('#ordersTable').dataTable({
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            "order": [[ 1, "desc" ]],
            iDisplayLength: 10
        });
});
</script>

@stop

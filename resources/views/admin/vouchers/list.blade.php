@extends('admin.layouts.control')

@section('content')

<section class="blogs page">
    <div class="actionbar">
        <div class="header">
            <h3>Order Notifications</h3>
        </div>
        <div class="button pull-right">
            <a href="vouchers/create" type="button" class="btn btn-success btn-sm">
                <i class="fa fa-plus-circle"></i> New Voucher
            </a>
        </div>
    </div>
    <table class="table" id="ordersTable">
        <thead>
            <tr>
                <th>Voucher Id</th>
                <th>Voucher Code</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th class="actioncol">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vouchers as $voucher)
            <tr data-id="{{ $voucher->vou_id }}">
                <td>{{ $voucher->vou_id }}</td>
                <td>{{ $voucher->vou_code }}</td>
                <td><?php echo date('d-m-Y H:i:s', strtotime($voucher->vou_start)); ?></td>
                <td><?php echo date('d-m-Y H:i:s', strtotime($voucher->vou_end)); ?></td>
                <td class="actioncol">
                    <a href="vouchers/edit/{{ $voucher->vou_id }}" type="button" class="btn btn-success btn-sm">
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
            "order": [[ 0, "desc" ]],
            iDisplayLength: 10
        });
});
</script>

@stop

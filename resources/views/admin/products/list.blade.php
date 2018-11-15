@extends('admin.layouts.control')

@section('content')

<section class="blogs page">
    <div class="actionbar">
        <div class="header">
            <h3>Order Notifications</h3>
        </div>
        <div class="button pull-right">
            <a href="products/create" type="button" class="btn btn-success btn-sm">
                <i class="fa fa-plus-circle"></i> New Product
            </a>
        </div>
    </div>
    <table class="table" id="ordersTable">
        <thead>
            <tr>
                <th>Product Id</th>
                <th>Product Name</th>
                <th>Category Name</th>
                <th class="actioncol">Actions</th>
            </tr>
        </thead>
        <tbody>
            {{Log::info($products)}}
            @foreach ($products as $product)
            <tr data-id="{{ $product->pro_id }}">
                <td>{{ $product->pro_id }}</td>
                <td>{{ $product->pro_name }}</td>
                <td>{{ $product->cat_name }}</td>
                <td class="actioncol">
                    <a href="products/edit/{{ $product->pro_id }}" type="button" class="btn btn-success btn-sm">
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
            "order": [[ 0, "asc" ]],
            iDisplayLength: 10
        });
});
</script>

@stop

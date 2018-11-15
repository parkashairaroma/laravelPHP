@extends('admin.layouts.control')

@section('content')

<section class="banners page">
    <div class="actionbar">
        <div class="header"><h3>Client Management</h3></div>
        <div class="button">
            <a href="clients/create" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> New Client</a>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th width="80%">Title</th>
                <th width="10px">Order</th>
                <th width="10px">Status</th>
                <th width="180px" class="actioncol">Actions</th>
            </tr>
        </thead>
        <tbody id="sortable">
            @foreach ($clients as $client)
            <tr data-id="{{ $client->cli_id }}" id="order-{{    $client->cli_id  }}">
                <td>
                    <a href="clients/edit/{{ $client->cli_id }}" class="tip" title="Edit">{{ $client->cli_name }}</a>
                </td>
                <td class="ordering">
                    <i class="fa fa-bars"></i>
                </td>
                <td>
                    <span class="label label-{{ $client->clipagweb_is_enabled == true ? "success" : "danger" }}">{!!    $client->clipagweb_is_enabled == true ? "Enabled" : "Disabled" !!}</span>
                </td>
                <td class="actioncol">
                    <a href="clients/edit/{{ $client->cli_id }}" class="btn btn-success btn-sm">
                        <i class="fa fa-pencil tip" title="Edit"></i>
                    </a>
                    <a class="btn btn-danger btn-sm delete" data-url="clients/delete/{{ $client->cli_id }}">
                        <i class="fa fa-times tip" title="Delete"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>

<script>
$(function() {

    $('.page')
    .on('click', '.delete', function() {
        if (! confirm('Are you sure?')) return false;
        var url = $(this).data('url');
        location.href=url;
    }); 

    /* enable table sorting */
    sortTable('/admin/api/clients/order');

});
</script>

@stop
@extends('admin.layouts.control')

@section('content')

<section class="banners page">
    <div class="actionbar">
        <div class="header"><h3>Banner Management</h3></div>
        <div class="button">
            <a href="banners/create" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> New Banner</a>
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
            @foreach ($banners as $banner)
            <tr data-id="{{ $banner->ban_id }}" id="order-{{ $banner->ban_id  }}">
                <td><a href="banners/edit/{{ $banner->ban_id }}" class="tip" title="Edit">{{ $banner->ban_name }}</a></td>
                <td class="ordering"><i class="fa fa-bars"></i></td>
                <td><span class="label label-{{ $bannerStatusColours[$banner->ban_status] }}">{!! $bannerStatusNames[$banner->ban_status] !!}</span></td>
                <td class="actioncol">
                    <a href="banners/edit/{{ $banner->ban_id }}" class="btn btn-success btn-sm"><i class="fa fa-pencil tip" title="Edit"></i></a>
                    <a class="btn btn-danger btn-sm delete" data-url="banners/delete/{{ $banner->ban_id }}"><i class="fa fa-times tip" title="Delete"></i></a>
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
    sortTable('/admin/api/banners/order');

});
</script>

@stop
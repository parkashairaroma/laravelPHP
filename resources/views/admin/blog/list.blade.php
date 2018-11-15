 @extends('admin.layouts.control')

@section('content')

<section class="blogs page">
    <div class="actionbar">
        <div class="header"><h3>Blog Management</h3></div>
        <div class="button pull-right">
            <a href="/blog" type="button" class="btn btn-default btn-sm"><i class="fa fa-eye"></i> View Blog</a>
            <a href="blog/create" type="button" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> New Entry</a>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th width="110px">Date</th>
                <th width="20px">Approval</th>
                <th width="5px">Status</th>
                <th width="130px" class="actioncol">Actions</th>
            </tr>
        </thead>
        <tbody id="sortable">
            @foreach ($blogs as $blog)
            <tr data-id="{{ $blog->blg_id }}">
                <td><a href="blog/edit/{{ $blog->blg_id }}" class="edit tip" title="Edit">{{ $blog->blg_title }}</a></td>
                <td>
                @if (blogCheckDate($blog->blg_date))
                    <i class="fa fa-caret-down text-success tip" title="Past Post"></i>
                @else
                    <i class="fa fa-caret-up text-danger tip" title="Future Post"></i>
                @endif
                {{ blogConvertDate($blog->blg_date) }}
                </td>
                <td>
                    <span class="label label-{{ $approvalColours[$blog->blg_approved] }}">{!! $approvalNames[$blog->blg_approved] !!}</span>
                </td>
                <td>
                    <span class="label label-{{ $statusColours[$blog->blg_status] }}">{{ $statusNames[$blog->blg_status] }}</span>
                </td>
                <td class="actioncol">
                    <a href="/blog/{{ $blog->blg_slug }}" type="button" class="btn btn-default btn-sm"><i class="fa fa-eye tip" title="View"></i></a>
                    <a href="blog/edit/{{ $blog->blg_id }}" type="button" class="btn btn-success btn-sm"><i class="fa fa-pencil tip" title="Edit"></i></a>
                    <a class="btn btn-danger btn-sm delete" data-url="blog/delete/{{ $blog->blg_id }}"><i class="fa fa-times tip" title="Delete"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="paginate">{{ $blogs->links() }}</div>
</section>

<script>
$(function() {
    $('.page')
    .on('click', '.delete', function() {
        if (! confirm('Are you sure?')) return false;
        var url = $(this).data('url');
        location.href=url;
    })
});
</script>

@stop
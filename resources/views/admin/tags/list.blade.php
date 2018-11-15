 @extends('admin.layouts.control')

@section('content')

<section class="tags page">
    <div class="actionbar">
        <div class="header"><h3>Tag Management</h3></div>
        <div class="button">
            <button type="button" class="btn btn-default btn-sm" id="save-all" disabled><i class="fa fa-save"></i> Save All</button>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th width="50%">Description</th>
                <th width="25%">Translated Name</th>
                <th width="25%">Translated Slug</th>
                <th width="5px" class="actioncol">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tags as $tag)
            <tr data-id="{{ $tag->tag_id }}">
                <td>{{ $tag->tag_name }}</td>
                <td><i class="fa fa-clone clone-name tip" title="Base: {{ $tag->base_name }}"></i>{{ Form::text('tat_name', $tag->site_name, ['placeholder' => $tag->base_name, 'class' => 'form-control']) }}</td>
                <td><i class="fa fa-clone clone-name tip" title="Base: {{ $tag->base_slug }}"></i>{{ Form::text('tat_slug', $tag->site_slug, ['placeholder' => $tag->base_slug, 'class' => 'form-control']) }}</td>
                <td class="actioncol">
                    <button type="button" class="btn btn-default btn-sm save" disabled><i class="fa fa-save tip" title="Save"></i></button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>

<script>
$(function() {
    $('.page')
    .on('click', '.clone-name', function() {
        $(this).next('input').val($(this).next('input').attr('placeholder'));
        enableSaveButton($(this));
    })
    .on('click', '#save-all', function() {
        saveAll($(this));
    })
    .on('click', '.save', function () {

        $(this).prop('disabled', true);

        var row = $(this).parents('tr');
        var data = row.find('input').serialize();
        var id = row.data('id');
        
        api('put', '/admin/api/tags/edit/' + id, data).done(function (response) {
            disableSaveButton($(this));
        });
    })
    .on('keyup paste', 'input[type="text"]', function () {
        enableSaveButton($(this));
    });
});
</script>
@stop
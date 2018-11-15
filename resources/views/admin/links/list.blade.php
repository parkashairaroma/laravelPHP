 @extends('admin.layouts.control')

@section('content')

<section class="links page">
    <div class="actionbar">
        <div class="header"><h3>Link Management</h3></div>
        <div class="button">
            <button type="button" class="btn btn-default btn-sm" id="save-all" disabled><i class="fa fa-save"></i> Save All</button>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th width="70%">Description</th>
                <th width="30%">Translated URL</th>
                <th width="5px" class="actioncol">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($links as $link)
            <tr data-id="{{ $link->pag_id }}">
                <td>{{ $link->pag_name }}</td>
                <td><i class="fa fa-clone clone-name tip" title="Base: {{ $link->base_url }}"></i>{{ Form::text('lts_url', $link->site_url, ['placeholder' => $link->base_url, 'class' => 'form-control']) }}</td>
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
        
        api('put', '/admin/api/links/edit/' + id, data).done(function (response) {
            disableSaveButton($(this));
        });
    })
    .on('keyup paste', 'input[type="text"]', function () {
        enableSaveButton($(this));
    });
});
</script>
@stop
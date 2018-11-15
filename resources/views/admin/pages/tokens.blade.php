 @extends('admin.layouts.control')

@section('content')

<section class="pages page">
    <div class="actionbar">
        <div class="header"><h3>Translation Management</h3></div>
        <div class="button">
            @if ($page->pag_subsite == 0)
                <button type="button" class="btn btn-default btn-sm visit-page"><i class="fa fa-eye"></i> Visit {{ $page->pag_name }}</button>
            @endif
            @if (in_array('manage_tokens', $authRoles) && $isBase)
                <button type="button" class="btn btn-success btn-sm new-token"><i class="fa fa-plus"></i> New Token</button>
            @endif
            <button type="button" class="btn btn-default btn-sm" id="save-all" disabled><i class="fa fa-save"></i> Save All</button>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th width="20%">Token</th>
                <th width="40%">Default Text</th>
                <th width="40%">Translated Text</th>
                <th width="5px" class="actioncol">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tokens as $token)
            <tr data-id="{{ $token->ptk_id }}">
                <td><span class="token">{{ $token->ptk_token }}</span></td>
                <td><i class="fa fa-clone clone-name tip" title="Copy Default"></i>{{ Form::textarea(null, $token->base_translation, ['class' => 'form-control readonly-textbox', 'disabled' => 'true']) }}</td>
                <td>{{ Form::textarea('pgt_value', $token->site_translation, ['class' => 'form-control translated-textbox']) }}</td>
                <td class="actioncol">
                    <button type="button" class="btn btn-default btn-sm save" disabled><i class="fa fa-save tip" title="Save"></i></button>
                    @if (in_array('manage_tokens', $authRoles)  && $isBase)
                        <button type="button" class="btn btn-danger btn-sm delete"><i class="fa fa-times tip" title="Delete"></i></button>
                    @endif
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
        var source = $(this).parents('tr').find('.readonly-textbox').val();
        $(this).parents('tr').find('.translated-textbox').val(source);
        enableSaveButton($(this));
    })
    .on('click', '#save-all', function() {
        saveAll($(this));
    })
    .on('click', '.save-new', function() {

        $(this).prop('disabled', true);

        var row = $(this).parents('tr') 
        var data = row.find('input, textarea').serialize();

        api('post', '/admin/api/tokens/create', data).done(function (response) {
            row.find('td:first').html(row.find('input').val())
            row.find('.save-new').switchClass('save-new', 'save');
            disableSaveButton($(this));
            row.attr('data-id', response.tokenId);
        });
    })
    .on('click', '.new-token', function() {

        var html =  '<tr>' + 
                    '  <td>' +
                    '       <input type="text" name="ptk_token" class="form-control">' + 
                    '       <input type="hidden" name="ptk_pag_id" value="' + {{ $page->pag_id }} + '" class="form-control">' + 
                    '  </td>' +
                    '  <td colspan="2">' +
                    '       <textarea name="pgt_value" class="form-control"></textarea>' + 
                    '  </td>' +
                    '  <td class="actioncol">' +
                    '       <button type="button" class="btn btn-success btn-sm save-new"><i class="fa fa-save tip" title="Save"></i></button>' +
                    '       <button type="button" class="btn btn-danger btn-sm delete-new"><i class="fa fa-times tip" title="Remove"></i></button>' +
                    '   </td>' +
                    '</tr>';

        $('.table tbody').prepend(html);

        addToolTip();

    })
    .on('click', '.delete-new', function() {
        if (! confirm('Are you sure?')) return false;
        var row = $(this).parents('tr') 
        row.remove();
    })
    .on('click', '.visit-page', function() {
        location.href='{{ $links[$page->pag_url]['url'] }}';
    })
    .on('click', '.delete', function () {
        if (! confirm('Are you sure?')) return false;
        var row = $(this).parents('tr')
        var id = row.data('id');

        api('delete', '/admin/api/tokens/delete/' + id).done(function (response) {
            disableSaveButton($(this));
            row.remove();
        });
    })
    .on('click', '.save', function () {

        var row = $(this).parents('tr')
        var data = row.find('input, textarea').serialize();
        var id = row.data('id');

        api('put', '/admin/api/tokens/edit/' + id, data).done(function (response) {
            disableSaveButton($(this));
        });
    })
    .on('keyup paste', 'input[type="text"], textarea', function () {
         enableSaveButton($(this));
    });
});
</script>
@stop
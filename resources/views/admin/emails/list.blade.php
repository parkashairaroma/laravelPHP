@extends('admin.layouts.control')

@section('content')

<section class="emails page">
    <div class="actionbar">
        <div class="header"><h3>Emails Management</h3></div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Email Type</th>
                <th>
                    Regions
                </th>
                <th>Email Addresses
                    <i class="fa fa-info-circle" rel="tooltip" title="Email Addresses should be seperated by ;" id="blah"></i></th>
                <th width="5px" class="actioncol">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($emaillist as $email)
            <tr data-id="{{ $email->eml_ety_id }}" data-reg="{{ $email->reg_id }}">
                <td>{{ $email->ety_name }}</td>
                <td>{{ $email->reg_name }}</td>
                <td>
                    <input id="emails" class="form-control" name="emails" type="text" value="{{ $email->eml_address }}" />
                </td>
                <td class="actioncol">
                    <button type="button" class="btn btn-default btn-sm tip save" title="Save">
                        <i class="fa fa-save"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>

{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js') !!}
{!!Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.4/js/bootstrap-select.min.js') !!}

<script>
$(function() {

	$('.save').click(function() {
        var row = $(this).parents('tr')
        var data = row.find('input').serialize();
        var emails = row.find('input').val();
        var id = row.data('id');
        var reg = row.data('reg');
        if (reg == "")
        {
            reg = 0;
        }

        api('put', '/admin/api/emails/edit/' + id + '/' + reg + '/' + emails, data).done(function (response) {
            row.find('.save').switchClass('btn-success', 'btn-default');
        });
	});

	$('input').change(function () {
        var row = $(this).parents('tr')
		row.find('.save').switchClass('btn-default', 'btn-success');
	});
});
</script>

@stop

@extends('admin.layouts.control')

@section('content')
<section class="users page">
    <div class="actionbar">
        <div class="header"><h3>User Management</h3></div>
        <!--<div class="button pull-right">
            <a href="users/create" type="button" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> New User</a>
        </div>-->
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Username</th>
                @if (isset($websitesList))
                <th width="100px">Websites</th>
                @endif
                <th width="100px">Roles</th>
                <th width="5px" class="actioncol">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr data-id="{{ $user->usr_id }}" >
                <td>{{    $user->usr_name }}</td>
                @if (isset($websitesList))
                <td class="usr_websites">
                    {!! Form::select('usr_websites[]', $websitesList, $user->websites->lists('web_id')->toArray(), ['multiple' => 'multiple', 'id' => 'usr_websites', 'style' => 'display: none', 'class' => 'form-control']) !!}              </div>
                </td>
                @endif
                <td class="usr_roles">
					               {!! Form::select('usr_roles[]', $rolesList, $user->roles->lists('rol_id')->toArray(), ['multiple' => 'multiple', 'id' => 'usr_roles', 'style' => 'display: none', 'class' => 'form-control']) !!}</div>
                </td>
                <td class="actioncol">
                    <button type="button" class="btn btn-default btn-sm tip save" title="Save"><i class="fa fa-save"></i></button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>

{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.4/js/bootstrap-select.min.js') !!}

<script>
$(function() {

	$('.usr_roles select').selectpicker({
        selectedTextFormat: 'count'
    });

    $('.usr_websites select').selectpicker({
        selectedTextFormat: 'count > 2',
        liveSearch: true,
        actionsBox: true
    });


	$('.save').click(function() {
        var row = $(this).parents('tr') 
        var data = row.find('select').serialize();
		var id = row.data('id');

        api('put', '/admin/api/users/edit/' + id, data).done(function (response) {
            row.find('.save').switchClass('btn-success', 'btn-default');
        });
	});

	$('select').change(function() {
        var row = $(this).parents('tr') 
		row.find('.save').switchClass('btn-default', 'btn-success');
	});
});
</script>
@stop
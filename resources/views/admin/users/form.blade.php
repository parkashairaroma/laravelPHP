 @extends('admin.layouts.control')

@section('content')

<section class="users page">
    @if (isset($user))
    {!! Form::model($user, ['method' => 'post', 'id' => 'form']) !!}
    @else
    {!!Form::open(['method' => 'post', 'id' => 'form']) !!}
    @endif

    <div class="actionbar">
        <div class="header">
            <h3>Create User</h3>
        </div>
        <div class="button pull-right">
            <a href="#" type="button" class="btn btn-success btn-sm" onclick="$('#form').submit();">
                <i class="fa fa-save"></i> Save
            </a>
        </div>
    </div>

    <div class="block-fields">
        <div class="block-row block-flex {!!$errors->first('login', 'missing-field') !!}">
            <div class="name block-2">
                <label>User Name</label>
            </div>
            <div class="value block-10">{!!Form::text('login', null, ['id' => 'login', 'class' => 'form-control']) !!}</div>
        </div>
        <div class="block-row block-flex {!!$errors->first('password', 'missing-field') !!}">
            <div class="password block-2">
                <label>User Password</label>
            </div>
            <div class="value block-10">{!!Form::password('password', array('class' => 'form-control')) !!}</div>
        </div>
        <div class="block-row block-flex {!!$errors->first('user_email', 'missing-field') !!}">
            <div class="email block-2">
                <label>User Email</label>
            </div>
            <div class="value block-10">{!!Form::text('user_email', null, ['id' => 'user_email', 'class' => 'form-control']) !!}</div>
        </div>
    </div>

</section>
    @stop

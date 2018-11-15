 @extends('admin.layouts.control')

@section('content')

<section class="products page">

    @if (isset($voucher))
	    {!!Form::model($voucher, ['method' => 'post', 'id' => 'form', 'files' => true]) !!}
    @else
	    {!!Form::open(['method' => 'post', 'id' => 'form' , 'files' => true]) !!}
    @endif

    <div class="actionbar">
        <div class="header">
            <h3>Voucher Details</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h4>Voucher Information</h4>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="row {!!$errors->first('vou_code', 'missing-field') !!}">
                        <div class="col-md-6">Code <i class="fa fa-info-circle" rel="tooltip" title="Place voucher code here"></i></div>
                        <div class="col-md-6">
                            {{Form::text('vou_code', isset($voucher) ? $voucher->vou_code : null, ['placeholder' => isset($voucher) ? $voucher->vou_code : null, 'class' => 'form-control'])}}
                            {!!$errors->first('vou_code', '<span class="field-message">:message</span>') !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="row {!!$errors->first('vou_start', 'missing-field') !!}">
                        <div class="col-md-6">Start Date <i class="fa fa-info-circle" rel="tooltip" title="Voucher Start Date needs to be in format of dd-mm-yyyy hh:mm:ss"></i></div>
                        <div class="col-md-6">
                            <div class="input-group date">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                {!! Form::text('vou_start', isset($voucher) ? date('Y-m-d', strtotime($voucher->vou_start)) : null, ['id' => 'vou_start', 'class' => 'form-control']) !!}
                                {!!$errors->first('vou_start', '<span class="field-message">:message</span>') !!}
                            </div>
                            <div class="input-group time">
                                <span class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                                <input type="time" name="vou_starttime" class="form-control" value="<?php echo isset($voucher) ? date('H:i', strtotime($voucher->vou_start)) : "00:00" ?>" />
                                {!!$errors->first('vou_starttime', '<span class="field-message">:message</span>') !!}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="row {!!$errors->first('vou_start', 'missing-field') !!}">
                        <div class="col-md-6">End Date <i class="fa fa-info-circle" rel="tooltip" title="Voucher End Date needs to be in format of dd-mm-yyyy hh:mm:ss"></i></div>
                        <div class="col-md-6">

                            <div class="input-group date">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                {{Form::text('vou_end', isset($voucher) ? date('Y-m-d', strtotime($voucher->vou_end)) : null, ['id' => 'vou_end', 'class' => 'form-control'])}}
                                {!!$errors->first('vou_end', '<span class="field-message">:message</span>') !!}
                            </div>


                            <div class="input-group time">
                                <span class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                                <input type="time" name="vou_endtime" class="form-control" value="<?php echo isset($voucher) ? date('H:i', strtotime($voucher->vou_end)) : "23:59" ?>" />
                                {!!$errors->first('vou_endtime', '<span class="field-message">:message</span>') !!}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="row {!!$errors->first('vou_website_id', 'missing-field') !!}">
                        <div class="col-md-6">Website ID </div>
                        <div class="col-md-6">
                            {!! Form::select('usr_websites[]', $websitesList, null , ['id' => 'usr_websites',  'class' => 'form-control']) !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="row {!!$errors->first('vou_discount', 'missing-field') !!}">
                        <div class="col-md-6">Discount <i class="fa fa-info-circle" rel="tooltip" title="Voucher discount needs to be in decimal format such as x.xx"></i></div>
                        <div class="col-md-6">
                            {{Form::text('vou_discount', isset($voucher) ? $voucher->vou_discount : "0.00", ['placeholder' => isset($voucher) ? $voucher->vou_discount : null, 'class' => 'form-control'])}}
                            {!!$errors->first('vou_discount', '<span class="field-message">:message</span>') !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="row {!!$errors->first('vou_type', 'missing-field') !!}">
                        <div class="col-md-6">Type <i class="fa fa-info-circle" rel="tooltip" title="Define type of voucher"></i></div>
                        <div class="col-md-6">
                            <select class="form-control" id="vou_type" name="vou_type">
                                <option value="percent">Percent</option>
                                <option value="dollars">Dollars</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!--<div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="row {!!$errors->first('vou_type', 'missing-field') !!}">
                        <div class="col-md-6">Threshold <i class="fa fa-info-circle" rel="tooltip" title="Define threshold in decimal format such as x.xx"></i></div>
                        <div class="col-md-6">
                            {{Form::text('vou_threshold', isset($voucher) ? $voucher->vou_threshold : null, ['placeholder' => isset($voucher) ? $voucher->vou_threshold : null, 'class' => 'form-control'])}}
                            {!!$errors->first('vou_threshold', '<span class="field-message">:message</span>') !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>-->



    <div class="row">
        <div class="col-md-12">
            &nbsp;
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="text-align:right;">
            @if  (in_array('edit_vouchers', $authRoles))
            <button type="button" class="btn btn-success" id="Edit">Save</button>
            @endif
            <button type="button" class="btn btn-danger" onclick="window.location.href='/admin/products'">Cancel</button>
        </div>
    </div>


</section>

{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.4/js/bootstrap-select.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js') !!}



<script>
        $( document ).ready(function() {

        $(".input-group.date").datepicker({
		autoclose: true,
		format: 'yyyy-mm-dd'
	});
                $('#usr_websites').append($('<option>', {
        value: 0,
        text : 'None'
    }));
            $('#usr_websites').val(<?php echo isset($voucher) ? $voucher->vou_website_id : 0; ?>);

    $('#vou_type').val("<?php echo isset($voucher) ? $voucher->vou_type : null?>");

        $('#Edit').click(function () {
            $('#form').submit();
        })

        });


</script>

@stop

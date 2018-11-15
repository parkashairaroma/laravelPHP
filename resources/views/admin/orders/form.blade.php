 @extends('admin.layouts.control')

@section('content')

<section class="orders page">

    @if (isset($product))
        {!! Form::model($order, ['method' => 'post', 'id' => 'form']) !!}
    @else
        {!!Form::open(['method' => 'post', 'id' => 'form']) !!}
    @endif

    <div class="actionbar">
        <div class="header">
            <h3>Order Details</h3>
        </div>
    </div>

    <div class="alert alert-danger alert-dismissable" id="errorDiv" style="display:none;">
    </div>

    <div class="alert alert-success alert-dismissable" id="successDiv" style="display:none;">
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4>Details</h4>
                <div class="row">
                    <div class="col-md-6">Order Number </div>
                    <div class="col-md-6">
                        <?php
                        $OrderNumber = "";
                        if($order->ord_website_id == 1)
			            {
				            $OrderNumber .= "AA";
			            }elseif($order->ord_website_id == 4)
			            {
				            $OrderNumber .= "AU";
			            }else {
				            $OrderNumber .= "WW";
			            }
			            $OrderNumber .= date("Ym", strtotime($order->ord_date));
			            $OrderNumber .= $order->ord_id;
                        echo $OrderNumber;
                        ?>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">Date </div>
                    <div class="col-md-6"><?php echo date('d-m-Y H:i:s', strtotime($order->ord_date)); ?></div>
                </div>
                <div class="row">
                    <div class="col-md-6">Status</div>
                    <div class="col-md-6">
                        <select name="selStatus" id="selStatus" style="width:250px;margin:0;padding:0;" class="form-control">
						    <option value="1" <?=($order->ord_status == 1)?'selected':''?>>New</option>
						    <option value="2" <?=($order->ord_status == 2)?'selected':''?>>Processing</option>
						    <option value="3" <?=($order->ord_status == 3)?'selected':''?>>Cancelled</option>
						    <option value="4" <?=($order->ord_status == 4)?'selected':''?>>Shipped</option>
						</select>
                    </div>
                </div>
                <!--<div class="row">
                    <div class="col-md-6">Paid</div>
                    <div class="col-md-6">
                        <select name="selPaidInFull" id="selPaidInFull" style="width:250px;margin:0;padding:0;" class="form-control">
						    <option value="0" <?=($order->ord_paidinfull == 0)?'selected':''?>>No</option>
							<option value="1" <?=($order->ord_paidinfull == 1)?'selected':''?>>Yes</option>
						</select>
                    </div>
                </div>-->
                <div class="row">
                    <div class="col-md-6">Tracking Number</div>
                    <div class="col-md-6"><input type="text" name="txtTrackingNumber" id="txtTrackingNumber" class="form-control" style="width:250px" value="<?=$order->ord_trackingnumber?>" /></div>
                </div>
                <div class="row">
                    <div class="col-md-6">Shipping Company</div>
                    <div class="col-md-6">
                        <?php
                        $ShippingCompanies = $shippingservices;
                        ?>
								<select name="selTrackingCompany" id="selTrackingCompany" style="width:250px" class="form-control">
									<option value="0">None</option>
									<?php
									if(count($ShippingCompanies)>0)
									{
										foreach($ShippingCompanies as $SC)
										{
                                    ?>
											<option value="<?=$SC->shc_id?>" data-trackinglink="<?=$SC->shc_trackinglink?>" <?=($order->ord_trackingcompany == $SC->shc_id)?'selected="selected"':''?>><?=$SC->shc_name?></option>
											<?php
										}
									}
                                            ?>
								</select> 
                    </div>
                </div>
                <div>
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <a id="trackinglink" href="#" style="text-decoration: underline;">Tracking Link</a>
                        <a id="sendtrackinglink" href="#" style="text-decoration: underline; float:right;">Send Tracking Email</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">Shipping Email Sent</div>
                    <div class="col-md-6" id="shippingemailflag">
                        <?php
                        $trackingEmailSent = "No";
                        if($order->ord_trackingemailsent == 1)
			            {
				            $trackingEmailSent = "Yes";
			            }
                        echo $trackingEmailSent;
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">Payment Type</div>
                    <div class="col-md-6">
                        <?php
								switch($order->ord_paymenttype)
								{
									case "creditcard":
										echo "Credit Card";
										break;
									case "cod":
										echo "Cash on Delivery";
										break;
									case "directdeposit":
										echo "Direct Deposit";
										break;
									case "paypal":
										echo "Paypal";
										break;
         case "ApplePay":
             echo "Apple Pay";
             break;
         case "GooglePay":
             echo "Google Pay";
             break;
								}
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">Payment Reference</div>
                    <div class="col-md-6">
                        <?php
								if($order->ord_paymentreference == "")
								{
									echo "None";
								}
								else {
									echo $order->ord_paymentreference;
								}
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">Email Address</div>
                    <div class="col-md-6"><input type="text" name="txtEmail" id="txtEmail" class="form-control" style="width:250px" value="<?=$order->acc_email?>" /></div>
                </div>
                <div class="row">
                    <div class="col-md-6">First Name</div>
                    <div class="col-md-6"><input type="text" name="txtFirstName" id="txtFirstName" class="form-control" style="width:250px" value="<?=$order->ord_firstname?>" /></div>
                </div>
                <div class="row">
                    <div class="col-md-6">Last Name</div>
                    <div class="col-md-6"><input type="text" name="txtLastName" id="txtLastName" class="form-control" style="width:250px" value="<?=$order->ord_lastname?>" /></div>
                </div>
                <div class="row">
                    <div class="col-md-6">Phone</div>
                    <div class="col-md-6"><input type="text" name="txtPhone" id="txtPhone" class="form-control" style="width:250px" value="<?=$order->ord_phone?>" /></div>
                </div>
                <div class="row">
                    <div class="col-md-6">Street</div>
                    <div class="col-md-6"><input type="text" name="txtStreet" id="txtStreet" class="form-control" style="width:250px" value="<?=$order->ord_street?>" /></div>
                </div>
                <div class="row">
                    <div class="col-md-6">Apt/Suite</div>
                    <div class="col-md-6"><input type="text" name="txtApt" id="txtApt" class="form-control" style="width:250px" value="<?=$order->ord_aptsuite?>" /></div>
                </div>
                <div class="row">
                    <div class="col-md-6">City</div>
                    <div class="col-md-6"><input type="text" name="txtCity" id="txtCity" class="form-control" style="width:250px" value="<?=$order->ord_city?>" /></div>
                </div>
                <div class="row">
                    <div class="col-md-6">State</div>
                    <div class="col-md-6" id="contact-form-state-div">
                        @if($orderstate != null) 
                            <select id="contact-form-state" name="contact-form-state" class="form-control" style="width:250px">
                                <option>None</option>
                                    @if(count($states))
                                        @foreach ($states as $state)
                                            @if ($state->sta_code == $orderstate[0]->sta_code)
                                                <option selected="selected" value="{{ $state->sta_id }}">{{ $state->sta_name }}</option>
                                            @else
                                                <option value="{{ $state->sta_id }}">{{ $state->sta_name }}</option>
                                            @endif
                                        @endforeach
                                    @endif     
                            </select>
                        @else
                            <input type="text" name="contact-form-state" id="contact-form-state" class="form-control" style="width:250px" value="<?= $order->ord_state ?>" />
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">Postcode</div>
                    <div class="col-md-6"><input type="text" name="txtPostCode" id="txtPostCode" class="form-control" style="width:250px" value="<?= $order->ord_postcode ?>" /></div>
                </div>
                <div class="row">
                    <div class="col-md-6">Country</div>
                    <div class="col-md-6">
                        <select id="contact-form-country" name="contact-form-country" class="form-control" style="width:250px">
                            <option>None</option>
                             @if(count($countries))
                                @foreach ($countries as $country)
                                     @if ( $country->cou_code == $order->cou_code)
                                        <option selected="selected" value="{{ $country->cou_id }}" code="{{ $country->cou_code }}">{{ $country->cou_name }}</option>
                                    @else
                                        <option value="{{ $country->cou_id }}" code="{{ $country->cou_code }}">{{ $country->cou_name }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h4>Pricing</h4>
                <div class="row">
                    <div class="col-md-6">Cost of Goods </div>
                    <div class="col-md-6">{{$order->cur_symbol}}{{$order->ord_goodscost}} </div>
                </div>
                <div class="row">
                    <div class="col-md-6">Voucher Code </div>
                    <div class="col-md-6"><?=($order->ord_vouchercode != "") ? $order->ord_vouchercode:'No Code Entered'?></div>
                </div>
                <div class="row">
                    <div class="col-md-6">Voucher Discount</div>
                    <div class="col-md-6">{{$order->cur_symbol}}{{$order->ord_voucherdiscount}}</div>
                </div>
                <div class="row">
                    <div class="col-md-6">Shipping Method</div>
                    <div class="col-md-6">{{$order->ord_shippingmethod}}</div>
                </div>
                <div class="row">
                    <div class="col-md-6">Shipping Cost</div>
                    <div class="col-md-6">{{$order->cur_symbol}}{{$order->ord_shippingcost}}</div>
                </div>
                <div class="row">
                    <div class="col-md-6">Surcharge Cost</div>
                    <div class="col-md-6">{{$order->cur_symbol}}{{$order->ord_surchargecost}}</div>
                </div>
                <div class="row">
                    <div class="col-md-6">Included Tax</div>
                    <div class="col-md-6">{{$order->cur_symbol}}{{$order->ord_taxincluded}}</div>
                </div>
                <div class="row">
                    <div class="col-md-6">Total Cost</div>
                    <div class="col-md-6">{{$order->cur_symbol}}{{$order->ord_totalcost}}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4>Products</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <table class="table" id="ordersTable">
				<?php
				if(count($orderproducts)>0)
				{
					$TotalItems = 0;
					$TotalCost = 0;
                ?>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Cost</th>
                            <th>Quantity</th>
                            <th>Total Cost</th>
                        </tr>
                    </thead>
                    <?php
					foreach($orderproducts as $OI)
					{
						$TotalItems += $OI->ordpro_quantity;
						$TotalCost += ($OI->ordpro_price * $OI->ordpro_quantity);
                ?>
					<tr>
						<td class="description">
							<?=$OI->pro_name?> <?php if ($OI->uni_size == 0) { echo ""; } else { echo $OI->uni_name; } ?> <?php if ($OI->col_id == 1) { echo ""; } else { echo $OI->col_name; } ?>
						</td>
						<td class="price item-unit">
							{{$order->cur_symbol}}<?=$OI->ordpro_price?>
						</td>
						<td class="quantity">
							<?=$OI->ordpro_quantity?>
						</td>
						<td class="price item-total">
							{{$order->cur_symbol}}<?=number_format($OI->ordpro_price * $OI->ordpro_quantity, 2, '.', '')?>							
						</td>
					</tr>
					<?php
					}
                    ?>
					<tr>
						<td class="description">&nbsp;</td>
						<td class="price item-unit"><p style="font-weight:bold;">Totals:</p></td>
						<td class="quantity"><p style="font-weight:bold;"><?=$TotalItems?></p></td>
						<td class="price item-total"><p style="font-weight:bold;">{{$order->cur_symbol}}<?=number_format($TotalCost, 2, '.', '')?></p></td>
					</td>
					<?php
				}
                    ?>
				</table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="text-align:right;">
                @if                                                                                                                                                                                                                 (in_array('edit_orders', $authRoles))
                 <button type="button" class="btn btn-success" id="Edit">Save</button>
                @endif
                <button type="button" class="btn btn-danger" onclick="window.location.href='/admin/orders'">Cancel</button>
            </div>
        </div>
    </div>
           
</section>

<script>

    function openInNewTab(url) {
        var win = window.open(url, '_blank');
        win.focus();
    }

    $(document).ready(function () {

        // On Contact Form Country Change, get States from API
        $('#contact-form-country').change(function () {
            $countryCode = $('option:selected', this).attr('code');
            if ($countryCode != null && $countryCode != "") {
                $.ajax({
                    method: "GET",
                    url: '/api/country/' + $countryCode + '/states',
                    dataType: "json",
                })
                .done(function (data) {
                    if (data.status == "success" && data.count > 0) {
                        $('#contact-form-state-div').html('<select id="contact-form-state" name="contact-form-state" class="form-control" style="width:250px"><option>None</option></select>');
                        $('#contact-form-state').find('option:gt(0)').remove().end();
                        $.each(data.states, function (key, state) {
                            $('#contact-form-state').append('<option value="' + state.sta_id + '">' + state.sta_name + '</option>');
                        });
                        $('#contact-form-state option:first').attr('selected', 'selected');
                        $('#contact-form-state').dropdown('set selected', $("#contact-form-state option:selected").val());
                        $('#contact-form-state').dropdown('set text', $("#contact-form-state option:selected").text());
                        $('div.form-group.state').show();
                    } else {
                        $('#contact-form-state').find('option:gt(0)').remove().end();
                        $('div.form-group.state').hide();
                    }
                });
            }
        });


        // On Contact Form Country Change, get States from API
        $('#sendtrackinglink').click(function () {

            orderId = <?php echo $order->ord_id; ?>;

            if ($('#txtTrackingNumber').val().length == 0)
            {
                $('#errorDiv').html('<strong>Error!</strong> Tracking Number is Empty.');
                $('#errorDiv').show();
            }
            else
            {
                if ($('#selTrackingCompany').val() == "0")
                {
                    $('#errorDiv').html('<strong>Error!</strong> Tracking Company is Empty.');
                    $('#errorDiv').show();
                }
                else
                {
                    $('#errorDiv').hide();

                    var optionTrackingLink = $('option:selected', $('#selTrackingCompany')).attr('data-trackinglink');
                    if (optionTrackingLink.indexOf('<<TRACKINGNUMBER>>') !== -1)        // For UPS with tracking number
                    {
                        optionTrackingLink = optionTrackingLink.replace("<<TRACKINGNUMBER>>", $('#txtTrackingNumber').val());
                    }

                    $.ajax({
                        method: "POST",
                        url: '/admin/orders/sendTrackingEmail',
                        dataType: "json",
                        data: {
                            orderid: orderId,
                            trackingnumber: $('#txtTrackingNumber').val(),
                            trackingcompany: $('#selTrackingCompany').val(),
                            trackinglink: optionTrackingLink,
                        }
                    })
                    .done(function(response)
                    {
                        $('#successDiv').html('<strong>Success!</strong> '+ response.msg);
                        $('#shippingemailflag').html('Yes');
                        $('#successDiv').show();
                    })
                    .error(function(data) { // the data parameter here is a jqXHR instance
                        var errors = data.responseJSON;
                        $('#errorDiv').html('<strong>Error!</strong> ' + errors);
                        $('#errorDiv').show();
                    });
                }
            }
        });

        $("#trackinglink").click(function () {
            if ($('#selTrackingCompany').val() != "0")
            {
                var optionTrackingLink = $('option:selected', $('#selTrackingCompany')).attr('data-trackinglink');
                if (optionTrackingLink.indexOf('<<TRACKINGNUMBER>>') !== -1)        // For UPS with tracking number
                {
                    optionTrackingLinkreplaced = optionTrackingLink.replace("<<TRACKINGNUMBER>>", $('#txtTrackingNumber').val());
                    openInNewTab(optionTrackingLinkreplaced);
                }
                else {
                    openInNewTab(optionTrackingLink);
                }
            }
        });

        $('#Edit').click(function () {
            $('#form').submit();
        })
    });
</script>

@stop

 @section('bodyClass', 'store aromax subnav')
@section('currentNav', 6)
@section('currentSubNav', 0)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-store')


<div class="container">
	{!! Form::open(['method' => 'post', 'id' => 'form']) !!}
	<div class="content-block">
		<div class="text-block tb-c">
			<h2>Account Details</h2>
		</div>
		<div class="grid large input-grid ig-a">
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="form-group @if ($errors->has('firstname')) error @endif">
							<label for="firstname">
								First Name {!! $errors->first('firstname', '
								<span class="message">:message</span>') !!}
							</label>
							{{ Form::text("firstname", $authedStoreUser->acc_firstname, ['id' => 'firstname', 'class' => 'ui-text']) }} 
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="form-group @if ($errors->has('lastname')) error @endif">
							<label for="lastname">
								Last Name {!! $errors->first('lastname', '
								<span class="message">:message</span>') !!}
							</label>
							{{ Form::text("lastname", $authedStoreUser->acc_lastname, ['id' => 'lastname', 'class' => 'ui-text']) }}
						</div>
					</div>
				</div>
			</div>
			@if (!$authedStoreUser->acc_facebookid)
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="form-group">
							<label for="email">Email</label>
							<a href="/store/account/email" class="ui-button">Change Email</a>
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="form-group">
							<label for="password">Password</label>
							<a href="/store/account/password" class="ui-button">Change Password</a>
						</div>
					</div>
				</div>
			</div>
			@endif
		</div>
	
		<div class="form-content fc-b">
			<h4>Newsletter</h4>
			<ul class="option-list">
				<li>
					
					<input type="checkbox" id="airaroma_newsletter" name="airaroma_newsletter" class="ui-checkbox" value="1"/>
					
					<label for="airaroma_newsletter">I would like to subscribe to the Air Aroma newsletter.</label>
				</li>
			</ul>
			{!! Form::submit('Save', ['class' => 'ui-button']) !!}
			@if ($authedStoreUser->acc_facebookid)
				<p>Your account is linked to Facebook.<br>If you'd like to change your linked email address or password, please do so from within Facebook.</p>
			@endif
		</div>

		@if (session()->get('checkout.address.is_business') == "1")
		<input type="hidden" id="is_businesshidden" name="is_businesshidden" value="1" />
		@else
		<input type="hidden" id="is_businesshidden" name="is_businesshidden" value="0" />
		@endif
		<!-- Address List -->
		<div class="shipping-address-book address-table cart-summary" style="display:block;">
			<div class="summary-header">
		 		<h3>Address Book</h3>
			</div>
			<table class="address-book-style">
				<tr class="rowborder">
					<th>Name</th>
					<th>Address</th>
					<th>Change</th>
				</tr>
				@if ($accountAddresses->count())
		@foreach ($accountAddresses as $accountAddress)
				<tr class="rowborder">
					<td>
						{{	  $accountAddress->add_firstname . " " . $accountAddress->add_lastname }}
					</td>
					<td>
						{{	  $accountAddress->add_street }}, {{	$accountAddress->add_city }}
					</td>
					<td>
						<a href="/store/account/address/edit/{{$accountAddress->add_id}}" class="edit-button edit-button-addressbook" style="text-decoration: none;">Edit</a>
						|
						<a href="/store/account/address/delete/{{$accountAddress->add_id}}" class="edit-button edit-button-addressbook" style="text-decoration: none;">Delete</a>
					</td>
				</tr>
				@endforeach
		@else
				<tr>
					<td colspan="4">No Addresses Found.</td>
				</tr>
				@endif
			</table>
		</div>

		@include('pages.store.partials.addresses-form', ['type' => 'editaddress','page' => 'account'])
	</div>
	{!! Form::close() !!}
</div>

<script>
	var editaddress = $('.editaddress-address-form');
	var shipping = $('.shipping-address-book');

	$(document).ready(function () {
        debugger;
        @if ($newsletterBool == true)
            $('#airaroma_newsletter')[0].checked = true;
        @endif

			@if ($editaddressectionflag == 1)
			showAddressEditor(editaddress, shipping);
			@endif

			$('.store')
				.on('change', '.editaddress-address-form #country_id', function() {
		var countryId = $(this).val();
		editaddress.find('#state_id').dropdown('clear');
		populateStates(editaddress, countryId, 'editaddress');
		togglePostcodeSearch('editaddress');
	})
		.on('change', '.editaddress-address-form #state_id', function() {
		var stateId = $(this).val();
		editaddress.find('#county_id').dropdown('clear');
		populateCounties(editaddress, stateId, 'editaddress');
				})
			.on('click', '.save-editaddress-address', function() {
		$('#form').append('<input type="hidden" name="form_type" value="editaddress">');
	})
	});

	function showAddressEditor(showform, hideform) {
		debugger;
	if(showform.is(':visible')) {

			closeAddressEditor();
	}
	else {

	 //		  $('.shipping-edit, .billing-edit').html('Edit');

		showform.show();

		if( hideform.is(':visible')) {
			hideform.hide();
		}

		scrollToElement(showform);
	}
	}

	function closeAddressEditor() {
			//$('.shipping-edit, .billing-edit').html('Edit');

	if($('.editaddress-address-form').is(':visible')) {
		$('.editaddress-address-form').hide();
	}
		if($('.shipping-address-book').is(':hidden')) {
		$('.shipping-address-book').show();
	}
	}

		function setupPostcodeSearch() {
	togglePostcodeSearch('shipping');
	togglePostcodeSearch('billing');
}

function togglePostcodeSearch(type) {
	var $country = $('.'+type+'-address-form #country_id');
	var $postcode = $('.'+type+'-address-form .postcode-search');

	countryId = $country.val();
	if(countryId == 192) {
		$postcode.search({
			apiSettings: {
					url: '/ajax/store/address/postcode/AU/{query}'
				},
				minCharacters: 3,
				fields: {
					results: 'localities',
					title: 'postcode',
					description: 'city'
				},
				onSelect: function(data) {
					$('input[name="address['+type+'][city]"]').val(data['city']);
					$select = $('select[name="address['+type+'][state_id]"]');
					$select.find('option:selected').removeAttr('selected');
					$select.dropdown('clear');
					$select.find('option[data-code="'+data['state']+'"]').prop('selected', true);
					$select.dropdown('set selected', $('select[name="address['+type+'][state_id]"] option:selected').eq(0).val());
					$select.dropdown('set text', $('select[name="address['+type+'][state_id]"] option:selected').eq(0).html());
				}
			});
	}
	else
	{
		$postcode.search('destroy');
	}
}

function populateCounties(elem, countryId, type) {

	api('get', '/ajax/store/counties').done(function (response) {
		if ($.type(response[countryId]) == 'undefined') {
			elem.find('#county_id').empty();
			elem.find(".counties span").replaceWith('<span><input type="hidden" name="address['+type+'][county_id]" value="0" id="county_id" class="ui-text"></span>');
		} else {
			elem.find(".counties span").replaceWith('<span>County <select name="address['+type+'][county_id]" id="county_id" class="ui fluid search selection dropdown"></select></span>');
			elem.find('#county_id').dropdown();
			elem.find("#county_id").append('<option value=""></option>');
			$.each(response[countryId], function(key, value) {
				elem.find("#county_id").append('<option value="'+key+'">'+value+'</option>');
			});
		}
	});
}

function populateStates(elem, stateId, type) {

	api('get', '/ajax/store/states').done(function (response) {
		if ($.type(response[stateId]) == 'undefined') {
			elem.find('#state_id').empty();
			elem.find(".states span").replaceWith('<span><input type="text" name="address['+type+'][state_id]" id="state_id" class="ui-text"></span>');
		} else {
			elem.find(".states span").replaceWith('<span><select name="address['+type+'][state_id]" id="state_id" class="ui fluid search selection dropdown"></select></span>');
			elem.find('#state_id').dropdown();
			elem.find("#state_id").append('<option value=""></option>');
			$.each(response[stateId], function(key, value) {
				elem.find("#state_id").append('<option value="'+key+'" data-code="'+value['code']+'">'+value['name']+'</option>');
			});

   $select = $('select[name="address['+type+'][state_id]"]');
			$select.find('option:selected').removeAttr('selected');
			$select.dropdown('clear');
			$select.find('option:eq(1)').prop('selected', true);
			$select.dropdown('set selected', $('select[name="address['+type+'][state_id]"] option:selected').eq(0).val());
			$select.dropdown('set text', $('select[name="address['+type+'][state_id]"] option:selected').eq(0).html());
		}
	});
}
</script>
@stop
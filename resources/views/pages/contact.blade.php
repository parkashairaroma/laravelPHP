@section('bodyClass', 'contact subnav')
@section('currentNav', 5)
@section('currentSubNav', 1)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-contact')
<div class="hero-block hb-b hb-a">	
	<div class="container">
		<div class="hero-content">
			<div class="grid large divider div-a">
    @if (websiteId() == 4)       <!-- For Australia -->   
				<div class="box">
					    <div class="box-cell">
						    <div class="box-content">
							    <div class="text-block tb-a">
								    <h3>{!! $translate->token('h_corporateoffice') !!}</h3>
               <p>Air Aroma International<br>26/91-95 Tulip Street<br>Cheltenham, VIC 3192<br>Australia</p>
               <p>Tel: +61 3 9017 3511<br>Fax: +61 3 9584 2971</p>
							    </div>
						    </div>
					    </div>
				    </div>
				<div class="box">
					    <div class="box-cell">
						    <div class="box-content">
							    <div class="text-block tb-a">
								    <h3>{!! $translate->token('h_localdistributor') !!}</h3>
								    <p>Air Aroma Australia<br>26/91-95 Tulip Street<br>Cheltenham, VIC 3192<br>Australia</p>
								    <p>Tel: +61 3 9017 3511<br>Fax: +61 3 9584 2971</p>
							    </div>
						    </div>
					    </div>
				    </div>
    @elseif (websiteId() == 5)
        <div class="box">
                    <div class="box-cell">
                        <div class="box-content">
                            <div class="text-block tb-a">
                                <h3>{!! $translate->token('h_corporateoffice') !!}</h3>
                                <p>Air Aroma EMEA<br>Groenekansweg 10-C<br>3737 AG Groenekan<br>The Netherlands</p>
                                <p>Tel: +31 30 285 1009</p>
                            </div>
                        </div>
                    </div>
                </div>
     <div class="box">
                    <div class="box-cell">
                        <div class="box-content">
                            <div class="text-block tb-a">
                                <h3>{!! $translate->token('h_localdistributor') !!}</h3>
                                <p>Air Aroma Australia<br>26/91-95 Tulip Street<br>Cheltenham, VIC 3192<br>Australia</p>
                                <p>Tel: +61 3 9017 3511<br>Fax: +61 3 9584 2971</p>
                            </div>
                        </div>
                    </div>
                </div>
    @else
       <div class="box">
           <div class="box-cell">
               <div class="box-content">
                   <div class="text-block tb-a">
                       <h3>{!! $translate->token('h_headoffice') !!}</h3>
                       <p>
                           Air Aroma USA<br />
                           263 West 38th St - 12th Floor<br />
                           New York, NY 10018<br />
                           United States of America<br />
                       </p>
                       <p>
                           Tel: +1 646 861 7872<br />
                           Fax: +1 212 704 2180
                       </p>
                   </div>
               </div>
           </div>
       </div>
    <div class="box">
           <div class="box-cell">
               <div class="box-content">
                   <div class="text-block tb-a">
                       <h3>{!! $translate->token('h_corporateoffice') !!}</h3>
                       <p>Air Aroma International<br>26/91-95 Tulip Street<br>Cheltenham, VIC 3192<br>Australia</p>
                       <p>Tel: +61 3 9017 3511<br>Fax: +61 3 9584 2971</p>
                   </div>
               </div>
           </div>
       </div>
    @endif
			</div>
		</div>
	</div>
</div>
@if(Session::has('successMessage'))
<div class="center text-block success">
	<span id="contact-submit-message" class="message">{!! $translate->token('text_thankyou') !!}</span>
</div>
@else
<div class="container">
	<div class="content-block">
		<div class="text-block">
			<form name="contact-form" method="POST">
				{{ csrf_field() }}
				<div class="form-group @if ($errors->has('contact-form-name')) error @endif">
					<label for="contact-form-name">{!! $translate->token('contact_form_name') !!} {!! $errors->first('contact-form-name', '<span class="message">:message</span>') !!}</label>
					<input type="text" id="contact-form-name" name='contact-form-name' class="ui-text" value="{{ Request::old('contact-form-name') }}">
				</div>
				<div class="form-group @if ($errors->has('contact-form-email')) error @endif">
					<label for="contact-form-email">{!! $translate->token('contact_form_email') !!} {!! $errors->first('contact-form-email', '<span class="message">:message</span>') !!}</label>
					<input type="email" id="contact-form-email" name='contact-form-email' class="ui-text" value="{{ Request::old('contact-form-email') }}">
				</div>
				<div class="form-group @if ($errors->has('contact-form-email2')) error @endif">
					<label for="contact-form-email2">{!! $translate->token('contact_form_email_confirm') !!} {!! $errors->first('contact-form-email2', '<span class="message">:message</span>') !!}</label>
					<input type="email" id="contact-form-email2" name='contact-form-email2' class="ui-text" value="{{ Request::old('contact-form-email2') }}">
				</div>
				<div class="form-group @if ($errors->has('contact-form-phone')) error @endif">
					<label for="contact-form-phone">{!! $translate->token('contact_form_phone') !!} {!! $errors->first('contact-form-phone', '<span class="message">:message</span>') !!}</label>
					<input type="phone" id="contact-form-phone" name="contact-form-phone" class="ui-text" value="{{ Request::old('contact-form-phone') }}">
				</div>
				<div class="form-group @if ($errors->has('contact-form-country')) error @endif">
					<label for="contact-form-country">{!! $translate->token('contact_form_country') !!} {!! $errors->first('contact-form-country', '<span class="message">:message</span>') !!}</label>
        <select id="contact-form-country" name="contact-form-country" class="fluid search" onchange="document.getElementById('country_text').value=this.options[this.selectedIndex].text">
            <option></option>
            @if(count($countries))
            @foreach ($countries as $country)
            @if ((Request::old('contact-form-country') !== null && $country->cou_code == Request::old('contact-form-country')) || $country->cou_code == $countryCode)
            <option selected="selected" value="{{ $country->cou_code }}">{{ $country->cou_name }}</option>
            @else
            <option value="{{ $country->cou_code }}">{{ $country->cou_name }}</option>
            @endif
            @endforeach
            @endif
        </select>
				</div>
       <input type="hidden" name="country_text" id="country_text" value="" />
				<div class="form-group state @if ($errors->has('contact-form-state')) error @endif" @if ( count($states) == 0 ) style="display:none" @endif>
					<label for="contact-form-state">{!! $translate->token('contact_form_state') !!} {!! $errors->first('contact-form-state', '<span class="message">:message</span>') !!}</label>
					<select id="contact-form-state" name="contact-form-state" class="fluid search">
					<option></option>
					@if(count($states))
						@foreach ($states as $state)
							@if (	(Request::old('contact-form-state') !== null && $state->sta_code == Request::old('contact-form-state')) || (Request::old('contact-form-state') === null && $state->sta_code == $stateCode ))
								<option selected="selected" value="{{ $state->sta_code }}">{{ $state->sta_name }}</option>
							@else 
								<option value="{{ $state->sta_code }}">{{ $state->sta_name }}</option>
							@endif
						@endforeach
					@endif
					</select>
				</div>
				<div class="form-group">
					<label for="contact-form-reason">{!! $translate->token('contact_form_reason') !!} {!! $errors->first('contact-form-reason', '<span class="message">:message</span>') !!}</label>
					<select id="contact-form-reason" name="contact-form-reason" class="fluid search">
						<option @if (Request::old('contact-form-reason') == 'contact_form_reason_general') selected="selected" @endif value="contact_form_reason_general">{!! $translate->token('contact_form_reason_general', false) !!}</option>
						<option @if (Request::old('contact-form-reason') == 'contact_form_reason_distributor') selected="selected" @endif value="contact_form_reason_distributor">{!! $translate->token('contact_form_reason_distributor', false) !!}</option>
						<option @if (Request::old('contact-form-reason') == 'contact_form_reason_sales') selected="selected" @endif value="contact_form_reason_sales">{!! $translate->token('contact_form_reason_sales') !!}</option>
						<option @if (Request::old('contact-form-reason') == 'contact_form_reason_product_support') selected="selected" @endif value="contact_form_reason_product_support">{!! $translate->token('contact_form_reason_product_support', false) !!}</option>
						<option @if (Request::old('contact-form-reason') == 'contact_form_reason_it_support') selected="selected" @endif value="contact_form_reason_it_support">{!! $translate->token('contact_form_reason_it_support', false) !!}</option>
					</select>
				</div>
				<div class="form-group @if ($errors->has('contact-form-message')) error @endif">
					<label for="contact-form-message">{!! $translate->token('contact_form_message') !!} {!! $errors->first('contact-form-message', '<span class="message">:message</span>') !!}</label>
					<textarea rows="8" id="contact-form-message" name="contact-form-message" class="ui-text">{{ Request::old('contact-form-message') }}</textarea>
				</div>
    <div class="form-group">
      <input type="checkbox" id="airaroma_newsletter" name="airaroma_newsletter" class="ui-checkbox" checked /> &nbsp; {!! $translate->token('contact_form_subscribe') !!}
    </div>
				<div class="form-group @if ($errors->has('recaptchaError')) error @endif">
					<span class="message">@if ($errors->has('recaptchaError')){!! $translate->token('text_tickbox') !!} @endif</span>
					<div class="g-recaptcha" data-sitekey="{{ $recaptchaSiteKey }}"></div>
				</div>
				<div class="form-action">
					<button type="submit" name="submit" class="ui-button">{!! $translate->token('contact_form_submit') !!}</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endif
{{-- Recaptcha --}}
@if (websiteId() == 5)       <!-- For Dutch -->
{!! Html::script('https://www.google.com/recaptcha/api.js?hl=nl') !!}
@else
{!! Html::script('https://www.google.com/recaptcha/api.js') !!}
@endif


<script>
    document.getElementById('country_text').value = document.getElementById('contact-form-country').options[document.getElementById('contact-form-country').selectedIndex].text;
</script>

@stop
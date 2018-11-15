<style>
    /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
    #map {
        height: 100%;
    }
    /* Optional: Makes the sample page fill the window. */
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
</style>
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">

<!-- Address Form -->
<div class="{{$type }}-address-form">

	<div class="grid large input-grid">
		<div class="box">
			<div class="box-cell">
				<div class="box-content">
					<div class="form-group @if ($errors->has('address.'.$type.'.firstname')) error @endif">
						<label for="firstname">First name {!! $errors->first('address.'.$type.'.firstname', '<span class="message">:message</span>') !!}</label>
						{{ Form::text("address[$type][firstname]", session()->get($page.'.address.'.$type.'.firstname'), ['id' => 'firstname', 'class' => 'ui-text']) }}
					</div>
				</div>
			</div>
		</div>
		<div class="box">
			<div class="box-cell">
				<div class="box-content">
					<div class="form-group @if ($errors->has('address.'.$type.'.lastname')) error @endif">
						<label for="lastname">Last name {!! $errors->first('address.'.$type.'.lastname', '<span class="message">:message</span>') !!}</label>
						{{Form::text("address[$type][lastname]", session()->get($page.'.address.'.$type.'.lastname'), ['id' => 'lastname', 'class' => 'ui-text']) }}
					</div>
				</div>
			</div>
		</div>

		<div class="box">
			<div class="box-cell">
				<div class="box-content">
					<div class="form-group @if ($errors->has('address.'.$type.'.street')) error @endif">
						<label for="street">Street Address {!! $errors->first('address.'.$type.'.street', '<span class="message">:message</span>') !!}</label>
						{{Form::text("address[$type][street]", session()->get($page.'.address.'.$type.'.street'), ['id' => 'street', 'class' => 'ui-text' , 'autocomplete' => 'false']) }}
					</div>
				</div>
			</div>
		</div>
  <div class="box">
            <div class="box-cell">
                <div class="box-content">
                    <div class="form-group @if ($errors->has('address.'.$type.'.suite')) error @endif">
                        <label for="street">
                            Apt/Suite {!! $errors->first('address.'.$type.'.suite', '
                            <span class="message">:message</span>') !!}
                        </label>
                        {{Form::text("address[$type][suite]", session()->get($page.'.address.'.$type.'.suite'), ['id' => 'suite', 'class' => 'ui-text' , 'autocomplete' => 'false']) }}
                    </div>
                </div>
            </div>
        </div>
		<div class="box">
			<div class="box-cell">
				<div class="box-content">
					<div class="form-group @if ($errors->has('address.'.$type.'.city')) error @endif">
						<label for="city">City {!! $errors->first('address.'.$type.'.city', '<span class="message">:message</span>') !!}</label>
						{{Form::text("address[$type][city]", session()->get($page.'.address.'.$type.'.city'), ['id' => 'city', 'class' => 'ui-text' , 'autocomplete' => 'false']) }}
					</div>
				</div>
			</div>
		</div>
		<div class="box">
			<div class="box-cell">
				<div class="box-content">
					<div class="form-group @if ($errors->has('address.'.$type.'.postcode')) error @endif">
						<label for="postcode">Zip / Postal Code {!! $errors->first('address.'.$type.'.postcode', '<span class="message">:message</span>') !!}</label>
						<div class="ui search postcode-search">
							<div class="ui icon input">
						    	{{Form::text("address[$type][postcode]", session()->get($page.'.address.'.$type.'.postcode'), ['id' => 'postcode', 'class' => 'ui-text prompt' , 'autocomplete' => 'false']) }}
						    	<i class="search icon"></i>
							</div>
						 	<div class="results"></div>
						</div>						
					</div>
				</div>
			</div>
		</div>
  <div class="box">
            <div class="box-cell">
                <div class="box-content">
                    <div class="form-group states @if ($errors->has('address.'.$type.'.state_id')) error @endif">
                        <label for="state_id">
                            State / Province / Region {!! $errors->first('address.'.$type.'.state_id', '
                            <div class="message">:message</div>') !!}
                        </label>
                        @if ( request()->old('address')[$type]['country_id'] && ! isset( $states[ request()->old('address')[$type]['country_id'] ] ) )

                        <span>{{Form::text("address[$type][state_id]", null, ['id' => 'state_id', 'class' => 'ui-text' , 'autocomplete' => 'false']) }}</span>

                        @elseif ( request()->old('address')[$type]['country_id'] )

							@include('pages.store.partials.states-dropdown', [
								'countryId' => request()->old('address')[$type]['country_id'],
								'stateId' => request()->old('address')[$type]['state_id'],
							])

						@else
							@if ( isset( $states[session()->get($page.'.address.'.$type.'.country_id')] ) )

								@include('pages.store.partials.states-dropdown', [
									'countryId' => session()->get($page.'.address.'.$type.'.country_id'),
									'stateId' => session()->get($page.'.address.'.$type.'.state_id'),
								])

							@else       <!-- Default USA -->
   
                        @if (session()->get($page.'.address.'.$type.'.country_id') != null)

                        <span>{{Form::text("address[$type][state_id]", session()->get($page.'.address.'.$type.'.state_id'), ['id' => 'state_id', 'class' => 'ui-text' , 'autocomplete' => 'false']) }}</span>

                        @else

                            @include('pages.store.partials.states-dropdown', [
                            'countryId' => '112',
                            'stateId' => session()->get($page.'.address.'.$type.'.state_id'),
                            ])

                        @endif

                        
                        @endif
						@endif
                    </div>
                </div>
            </div>
        </div>
		<div class="box">
			<div class="box-cell">
				<div class="box-content">
					<div class="form-group @if ($errors->has('address.'.$type.'.country_id')) error @endif">
						<label for="country_id">Country {!! $errors->first('address.'.$type.'.country_id', '<span class="message">:message</span>') !!}</label>
						@if (request()->old('address')[$type]['country_id']) 
							{{Form::select("address[$type][country_id]", [''=>'']+$countries, request()->old('address')[$type]['country_id'], ['id' => 'country_id', 'class' => 'ui fluid search selection dropdown' , 'autocomplete' => 'false']) }}
						@else
                            @if (session()->get($page.'.address.'.$type.'.country_id') != '')
                                {{Form::select("address[$type][country_id]", [''=>'']+$countries, session()->get($page.'.address.'.$type.'.country_id') , ['id' => 'country_id', 'class' => 'ui fluid search selection dropdown' , 'autocomplete' => 'false']) }}
                            @else
							    {{Form::select("address[$type][country_id]", [''=>'']+$countries, '112' , ['id' => 'country_id', 'class' => 'ui fluid search selection dropdown' , 'autocomplete' => 'false']) }}      <!-- Default USA -->
                            @endif
						@endif 
					</div>
				</div>
			</div>
		</div>

        <div class="box">
            <div class="box-cell">
                <div class="box-content">
                    <div class="form-group @if ($errors->has('address.'.$type.'.phone')) error @endif">
                        <label for="firstname">Phone {!! $errors->first('address.'.$type.'.phone', '<span class="message">:message</span>') !!}</label>
                        {{ Form::text("address[$type][phone]", session()->get($page.'.address.'.$type.'.phone'), ['id' => 'phone', 'class' => 'ui-text']) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="box">
        @if (session()->get($page.'.address.'.$type.'.is_business') == true)
            <div class="box businessname_div" style="display:block; width:100%;">
                @else
                <div class="box businessname_div" style="display:none; width:100%;">
                    @endif

                    <div class="box-cell">
                        <div class="box-content">
                            <div class="form-group @if ($errors->has('address.'.$type.'.businessname')) error @endif">
                                <label for="businessname">
                                    Business Name {!! $errors->first('address.'.$type.'.businessname', '
                                    <span class="message">:message</span>') !!}
                                </label>
                                <div class="ui search businessname-search">
                                    <div class="ui icon input">
                                        {{Form::text("address[$type][businessname]", session()->get($page.'.address.'.$type.'.businessname'), ['id' => 'businessname', 'class' => 'ui-text prompt']) }}
                                        <i class="search icon"></i>
                                    </div>
                                    <div class="results"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box businessaddress_sec">
                <div class="box-cell">
                    <div class="box-content">
                        <div class="form-group">
                            <ul class="option-list">
                                <li>
                                    @if (session()->get($page.'.address.'.$type.'.is_business'))
                                    <input type="checkbox" id="business_address" class="ui-checkbox" checked="checked"/ />
                                    @else
                                    <input type="checkbox" id="business_address" class="ui-checkbox" />
                                    @endif
                                    <label for="default">This is a business address</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box">
                <div class="box-cell">
                    <div class="box-content">
                        <div class="form-group">
                            <ul class="option-list">
                                @if ($type == 'shipping')
                                <li>
                                    <input type="checkbox" name="use_address_for_billing" id="use_address_for_billing" class="ui-checkbox" checked />
                                    <label for="default">Use the same address for billing</label>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>



            <div style="width:100%">
                <div class="box-cell">
                    <div class="box-content">
                        <div class="button-group" style="float:left;">
                            <button class="ui-button save-{{$type }}-address">Save</button>

                            @if ($type == 'editaddress' || $type == 'newaddress')

                            <button class="ui-button cancel-{{$type }}-address">Cancel</button>
                            @endif
                        </div>
                        <!--<div class="form-action">
                     <button class="ui-button cancel-{{$type }}-address">Cancel</button>
                    </div>-->
                    </div>
                </div>
            </div>
        </div>

</div>

<script>
    $(document).ready(function () {
        $('.businessaddress_sec :checkbox').change(function () {
            if ($(this).is(':checked')) {
                $('#is_businesshidden').val('1');
                $('.businessname_div').show();
            }
            else {
                $('#is_businesshidden').val('0');
                $('.businessname_div').hide();
            }

        });
    });

</script>

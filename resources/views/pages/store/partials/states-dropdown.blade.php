<span>
	<select name="address[{{ $type }}][state_id]" id="state_id" class="ui fluid search selection dropdown"> 
		@if (! $stateId )
			<option value="" selected></option>
		@endif
		@foreach ( $states[$countryId] as $id => $state )
			@if ( $stateId == $id )
				<option value="{{ $id }}" data-code="{{ $state['code'] }}" selected>{{ $state['name'] }}</option>
			@else
				<option value="{{ $id }}" data-code="{{ $state['code'] }}">{{ $state['name'] }}</option>
			@endif
		@endforeach
	</select>
</span>
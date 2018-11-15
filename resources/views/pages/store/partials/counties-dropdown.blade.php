<span>
	<select name="address[{{ $type }}][county_id]" id="county_id" class="ui fluid search selection dropdown"> 
		@if (! $countyId )
			<option value="0" selected></option>
		@endif
		@foreach ( $counties[$stateId] as $id => $county )
			@if ( $countyId == $id )
				<option value="{{ $id }}" selected>{{ $county }}</option>
			@else
				<option value="{{ $id }}">{{ $county }}</option>
			@endif
		@endforeach
	</select>
</span>
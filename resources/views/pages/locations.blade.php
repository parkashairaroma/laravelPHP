@section('bodyClass', 'locations subnav')
@section('currentNav', 5)
@section('currentSubNav', 2)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-contact')

<div class="hero-block hb-b hb-a">	
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h2>{!! $translate->token('h_locations') !!}</h2>
				<form>
					<div class="form-group">
						<label for="locations-country">{!! $translate->token('text_find') !!}</label>
						<select id="locations-country" class="fluid search" data-locationspage="{{ $link->create('/locations')->url() }}">
							<option value="0">{!! $translate->token('text_country') !!}</option>
							@if(count($countries))
								@foreach ($countries as $country)
									<option @if ( isset($countryCode) && $countryCode == $country->cou_code ) selected="selected" @endif data-countryslug="{{ $country->cou_slug }}" value="{{ $country->cou_code }}">{{ $country->cou_name }}</option>
								@endforeach
							@endif
						</select>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="content-block @if ($scrollToLocations)scrollto @endif" id="location-addresses">
		<div class="grid large divider div-a">
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block tb-a">
							<h3>{!! $translate->token('h_regionaloffice') !!}</h3>
							
							@if(isset($locations->regionalLocation))
								<p>
									@if ($locations->regionalLocation->LOC_TITLE !== '') {{ $locations->regionalLocation->LOC_TITLE }}<br />@endif
									@if ($locations->regionalLocation->LOC_ADDRESS1 !== '') {{ $locations->regionalLocation->LOC_ADDRESS1 }}<br />@endif
									@if ($locations->regionalLocation->LOC_ADDRESS2 !== '') {{ $locations->regionalLocation->LOC_ADDRESS2 }}<br />@endif
									@if ($locations->regionalLocation->LOC_ADDRESS3 !== '') {{ $locations->regionalLocation->LOC_ADDRESS3 }}<br />@endif
									@if ($locations->regionalLocation->LOC_ADDRESS4 !== '') {{ $locations->regionalLocation->LOC_ADDRESS4 }}<br />@endif
									@if ($locations->regionalLocation->LOC_ADDRESS5 !== '') {{ $locations->regionalLocation->LOC_ADDRESS5 }}@endif
								</p>
								<p>
									@if ($locations->regionalLocation->LOC_PHONE1 !== '') {{ 'Tel: ' . $locations->regionalLocation->LOC_PHONE1 }}<br />@endif
									@if ($locations->regionalLocation->LOC_PHONE2 !== '') {{ 'Tel: ' . $locations->regionalLocation->LOC_PHONE2 }}<br />@endif
									@if ($locations->regionalLocation->LOC_FAX1 !== '') {{ 'Fax: ' . $locations->regionalLocation->LOC_FAX1 }}<br />@endif
									@if ($locations->regionalLocation->LOC_FAX2 !== '') {{ 'Fax: ' . $locations->regionalLocation->LOC_FAX2 }}<br />@endif
									@if ($locations->regionalLocation->LOC_MOB1 !== '') {{ 'Mob: ' . $locations->regionalLocation->LOC_MOB1 }}<br />@endif
									@if ($locations->regionalLocation->LOC_MOB2 !== '') {{ 'Mob: ' . $locations->regionalLocation->LOC_MOB2 }}<br />@endif
									@if ($locations->regionalLocation->LOC_EMAIL1 !== '') {!! 'Email: <a href="mailto:' . $locations->regionalLocation->LOC_EMAIL1 . '">' . $locations->regionalLocation->LOC_EMAIL1 . '</a>' !!}<br />@endif
									@if ($locations->regionalLocation->LOC_EMAIL2 !== '') {!! 'Email: <a href="mailto:' . $locations->regionalLocation->LOC_EMAIL2 . '">' . $locations->regionalLocation->LOC_EMAIL2 . '</a>' !!}<br />@endif
									@if ($locations->regionalLocation->LOC_WEBSITE !== '') {!! 'Web: <a href="' . $locations->regionalLocation->LOC_WEBSITE . '">' . $locations->regionalLocation->LOC_WEBSITE . '</a>' !!}<br />@endif
								</p>
							@endif
							
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block tb-a">
							<h3>{!! $translate->token('h_distributors') !!}</h3>
							
							{{-- If Locations exist for the country, display them all --}}

							@if(count($locations->selectedCountryLocations))
								@foreach($locations->selectedCountryLocations as $location)
								<p>
									@if ($location->LOC_TITLE !== '') {{ $location->LOC_TITLE }}<br />@endif
									@if ($location->LOC_ADDRESS1 !== '') {{ $location->LOC_ADDRESS1 }}<br />@endif
									@if ($location->LOC_ADDRESS2 !== '') {{ $location->LOC_ADDRESS2 }}<br />@endif
									@if ($location->LOC_ADDRESS3 !== '') {{ $location->LOC_ADDRESS3 }}<br />@endif
									@if ($location->LOC_ADDRESS4 !== '') {{ $location->LOC_ADDRESS4 }}<br />@endif
									@if ($location->LOC_ADDRESS5 !== '') {{ $location->LOC_ADDRESS5 }}@endif
								</p>
								<p>
									@if ($location->LOC_PHONE1 !== '') {{ 'Tel: ' . $location->LOC_PHONE1 }}<br />@endif
									@if ($location->LOC_PHONE2 !== '') {{ 'Tel: ' . $location->LOC_PHONE2 }}<br />@endif
									@if ($location->LOC_FAX1 !== '') {{ 'Fax: ' . $location->LOC_FAX1 }}<br />@endif
									@if ($location->LOC_FAX2 !== '') {{ 'Fax: ' . $location->LOC_FAX2 }}<br />@endif
									@if ($location->LOC_MOB1 !== '') {{ 'Mob: ' . $location->LOC_MOB1 }}<br />@endif
									@if ($location->LOC_MOB2 !== '') {{ 'Mob: ' . $location->LOC_MOB2 }}<br />@endif
									@if ($location->LOC_EMAIL1 !== '') {!! 'Email: <a href="mailto:' . $location->LOC_EMAIL1 . '">' . $location->LOC_EMAIL1 . '</a>' !!}<br />@endif
									@if ($location->LOC_EMAIL2 !== '') {!! 'Email: <a href="mailto:' . $location->LOC_EMAIL2 . '">' . $location->LOC_EMAIL2 . '</a>' !!}<br />@endif
									@if ($location->LOC_WEBSITE !== '') {!! 'Web: <a href="' . $location->LOC_WEBSITE . '">' . $location->LOC_WEBSITE . '</a>' !!}<br />@endif
								</p>
								@endforeach
							@else
								<p>{!! $translate->token('text_nodistributors') !!}</p>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@stop
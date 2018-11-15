@section('bodyClass', 'legal subnav')
@section('currentNav', 0)
@section('currentSubNav', 1)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-legal')


<div class="container">
	
	<div class="content-block cb-a">
		<div class="legal-block">
			<h2>{!! $translate->token('h_policies') !!}</h2>
			<h3>{!! $translate->token('h_disclaimers') !!}</h3>
			
			<h4>{!! $translate->token('h_conditionsofuse') !!}</h4>
			<div>{!! $translate->token('text_conditionsofuse') !!}</div>
			
			<h4>{!! $translate->token('h_orders') !!}</h4>
			<div>{!! $translate->token('text_orders') !!}</div>
			
			<h4>{!! $translate->token('h_trademarks') !!}</h4>
			<div>{!! $translate->token('text_trademarks') !!}</div>
			
			<h4>{!! $translate->token('h_membership') !!}</h4>
			<div>{!! $translate->token('text_membership') !!}</div>
			
			<h4>{!! $translate->token('h_products') !!}</h4>
			<div>{!! $translate->token('text_products') !!}</div>
			
			<h4>{!! $translate->token('h_description') !!}</h4>
			<div>{!! $translate->token('text_description') !!}</div>
			
			<h4>{!! $translate->token('h_policiesmodifications') !!}</h4>
			<div>{!! $translate->token('text_policiesmodifications') !!}</div>
			
			<h4>{!! $translate->token('h_governinglaw') !!}</h4>
			<div>{!! $translate->token('text_governinglaw') !!}</div>
			
			<h4>{!! $translate->token('h_warrentycoverage') !!}</h4>
			<div>{!! $translate->token('text_warrentycoverage') !!}.</div>
		
		</div>
	</div>
	
	<div class="content-block">
		<div class="legal-block">
			<h3>{!! $translate->token('h_policies') !!}</h3>
			
			<h4>{!! $translate->token('h_creditcardpayment') !!}</h4>
			<div>{!! $translate->token('text_creditcardpayment') !!}</div>
			
			<h4>{!! $translate->token('h_shipping') !!}</h4>
			<div>{!! $translate->token('text_shipping') !!}</div>
			
			<h4>{!! $translate->token('h_internationalcustomers') !!}</h4>
			<div>{!! $translate->token('text_internationalcustomers') !!}</div>
			
			<h4>{!! $translate->token('h_returnspolicy') !!}</h4>
			<div>{!! $translate->token('text_returnspolicy') !!}</div>
			
			<h4>{!! $translate->token('h_privacypolicy') !!}</h4>
			<div>{!! $translate->token('text_privacypolicy') !!}</div>
			
			<h4>{!! $translate->token('h_personalinformation') !!}</h4>
			<div>{!! $translate->token('text_personalinformation') !!}</div>
			
			<h4>{!! $translate->token('h_cookies') !!}</h4>
			<div>{!! $translate->token('text_cookies') !!}</div>
			
			<h4>{!! $translate->token('h_secureinformation') !!}</h4>
			<div>{!! $translate->token('text_secureinformation') !!}</div>
			
			<h4>{!! $translate->token('h_questions') !!}</h4>
			<div>{!! $translate->token('text_questions') !!}</div>


			<div class="legal-contact-block">
				<p>
					<div class="legal-address">
						{!! $translate->token('text_corporateoffice') !!}
					</div>
					<div class="legal-contact">
						{!! $translate->token('text_contact') !!}
					</div>
				</p>
			</div>
		</div>
	</div>
</div>

@stop
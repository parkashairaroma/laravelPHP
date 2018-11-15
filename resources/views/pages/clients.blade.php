@section('bodyClass', 'clients')
@section('currentNav', 3)
@section('currentSubNav', 0)

@extends('layouts.pages')

@section('content')

<div class="hero-block">
	<div class="container">
		<div class="hero-content">
			<div class="text-block tb-a">
				<h1>{!! $translate->token('h_clients') !!}</h1>
				<p>{!! $translate->token('text_clients') !!}</p>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="content-block">
		<div class="grid square large gutter">
    
      @foreach ($clientspage as $clientpage)
      <!-- Client Image -->
      <div class="box">
          <a href="{{ $link->create('/clients')->url() }}/{{ $clientpage->cli_slug }}" class="box-cell">
              <div class="tile">
                  <div class="tile-content">
                      <div class="tile-label client">
                          <h3>{{ $clientpage->cli_name }}</h3>
                      </div>
                      <div class="tile-image">
                          <img src="{{ $clientpage->clt_cli_feature }}" alt="{!! $translate->token('h_clients', false) !!}" />
                      </div>
                  </div>
                  <div class="tile-overlay">
                      <span>{!! $translate->token('link_view') !!}</span>
                  </div>
              </div>
          </a>
      </div>
      @endforeach

		</div>
	</div>
	
	<div class="content-block">
		<div class="text-block tb-a tb-b">
			<h2>{!! $translate->token('h_greatbrands') !!}</h2>
			<p>{!! $translate->token('text_greatbrands') !!}</p>
		</div>
	</div>
	
	<div class="content-block">
		<div class="grid square small hairline">
			@foreach ($clients as $client)
			<div class="box" weight="{{ $client->cli_weight }}">
				<a class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-icon">
								<img src="{{ $clientLogoPath }}{{ $client->cli_slug }}.png" alt="{{ $client->cli_name }}">
							</div>
						</div>
					</div>
				</a>
			</div>
			@endforeach
		</div>
	</div>
	
</div>

@stop
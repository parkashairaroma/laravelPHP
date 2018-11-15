@section('bodyClass', 'home dark')

@extends('layouts.pages')

@section('content')

<div class="carousel">
	<!-- Slides -->
	@foreach ($banners as $key => $banner)
 @if ($banner->ban_store != true) 
	<div class="slide @if ($key > 0) preload @endif" style="background: {{ $banner->ban_overflow }};">
		<a href="{{ $banner->ban_link }}" class="hero-block" style="background-image: url('{{ $banner->ban_image }}')">
			<div class="container">
				<div class="hero-content">
					<div class="text-block">
         <h1 style="color: {{ $banner->ban_title_colour }}">{!! $banner->ban_title !!}</h1>
         <h3 style="color: {{ $banner->ban_description_colour }}">{!! $banner->ban_description !!}</h3>
					</div>
				</div>
			</div>
		</a>
	</div>
    @endif
	@endforeach
</div>

<div class="container">
	
	<div class="content-block cb-a">
		<div class="text-block">
			<h2>{!! $translate->token('h_page_title') !!}</h2>
			<p>{!! $translate->token('text_designingscents') !!}</p>
		</div>
	</div>
	
	<div class="content-block">
		<div class="text-block tb-a">
			<h3>{!! $translate->token('h_featuredclients') !!}</h3>
		</div>
	</div>

	<div class="content-block">
		<div class="grid square large gutter">
    
      @foreach ($clientsproject as $clientpage)
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
                      <span>{!! $translate->token('text_view') !!}</span>
                  </div>
              </div>
          </a>
      </div>
      @endforeach
 
		</div>
		<div class="grid square small hairline">

			<!-- Client Logo -->
			@foreach ($clients as $client)
			<div class="box">
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
		<div class="grid more hairline">
			<!-- View More -->
			<div class="box">
				<a href="{!! $link->create('/clients')->url() !!}" class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-label">
								<h3>{!! $translate->token('text_viewmoreclients') !!}</h3>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
		
	</div>
	
 @if (websiteId() != 5)     <!-- For Dutch site to remove Bottom section -->
	<div class="content-block">
		<div class="grid large divider">
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							@if (isset($blogs))
								<h3><a href="{!! $link->create('/blog')->url() !!}/{{ $blogs->blg_slug }}">{{ $blogs->blg_title }}</a></h3>
								<p>{!! paragraph($blogs->blg_content) !!}</p>
								<p><a href="{!! $link->create('/blog')->url() !!}/{{ $blogs->blg_slug }}">{!! $translate->token('text_readmore') !!}</a></p>
							@endif
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="box-content">
						<div class="text-block">
							<h3>{!! $translate->token('h_whoisscenting') !!}</h3>
							<p>{!! $translate->token('text_whoisscenting') !!}</p>
							<p>{!! $link->create('/scenting')->full('text_readmore') !!}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
 @endif
</div>
@stop
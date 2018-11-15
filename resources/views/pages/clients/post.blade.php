@section('bodyClass', 'clients dark')
@section('currentNav', 3)

@extends('layouts.pages')

@section('content')

<div class="hero-block hero-image" style="background-image: url({{ $clientPost->clt_cli_hero }});background-position: center center;">
    <div class="container">
        <div class="hero-content">
            <div class="text-block">
                <h1>{{ $clientPost->clt_cli_header }}</h1>
                <h2>{{ $clientPost->clt_cli_text }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="container">
	
	<div class="content-block">
		<div class="text-block">
			<h2>{{ $clientPost->clt_cli_scentheader }}</h2>
			<p><?php echo  paragraphClient($clientPost->clt_cli_scenttext) ?> </p>
		</div>
	</div>

@if($clientPost->clt_cli_video != null)
<div class="video-block">
    <iframe src="{{ $clientPost->clt_cli_video }}" width="500" height="281" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>
</div>
@endif

@if($clientPost->clt_cli_banner != null && $clientPost->clt_cli_banner != "" && $clientPost->clt_cli_banner != '<p contenteditable="false"></p>' && $clientPost->clt_cli_banner != '<p contenteditable="true"></p>' && $clientPost->clt_cli_banner != '<p></p>')
	<div class="content-block">
     <img src="{{ $clientPost->clt_cli_banner }}" alt="{{ $clientPost->clt_cli_header }}" />
	</div>
@endif
	
	<div class="content-block">

@if ($clientPost->clt_cli_textinner != null && $clientPost->clt_cli_textinner != "" && $clientPost->clt_cli_textinner != '<p contenteditable="false"></p>' && $clientPost->clt_cli_textinner != '<p contenteditable="true"></p>' && $clientPost->clt_cli_textinner != '<p></p>') 
 <div class="text-block">
            <p><?php echo paragraphClient($clientPost->clt_cli_textinner) ?></p>
        </div>
@endif

@if ($clientPost->clt_cli_quote != null && $clientPost->clt_cli_quote != "" && $clientPost->clt_cli_quote != '<p contenteditable="false"></p>' && $clientPost->clt_cli_quote != '<p contenteditable="true"></p>' && $clientPost->clt_cli_quote != '<p></p>')
	<div class="content-block cb-b">
		<div class="text-block tb-b">
			<p><?php echo paragraphClient($clientPost->clt_cli_quote) ?></p>
		</div>
	</div>
@endif

@if($clientPost->clt_cli_tile1 != null && $clientPost->clt_cli_tile2 != null)
		<div class="grid square large">
			<!-- Stretch Image -->
   @if($clientPost->clt_cli_tile1 != null)
			<div class="box dark">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-image">
           <img src="{{ $clientPost->clt_cli_tile1 }}" alt="{{ $clientPost->clt_cli_header }}" />
							</div>
						</div>
					</div>
				</div>
			</div>
    @endif
			<!-- Stretch Image -->
   @if($clientPost->clt_cli_tile2 != null)
			<div class="box dark">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-image">
           <img src="{{ $clientPost->clt_cli_tile2 }}" alt="{{ $clientPost->clt_cli_header }}" />
							</div>
						</div>
					</div>
				</div>
			</div>
   @endif
		</div>
@endif
	</div>
	
	<div class="content-block">
		<div class="grid large divider div-a">
			<div class="box">
				<div class="box-cell">
					<div class="text-block">
						<div class="feature-icon icon-phone"></div>
						<h3>{!! $translate->token('clt_cli_h_callus') !!}</h3>
						<p>{!! $translate->token('clt_cli_text_callus') !!}</p>
						<p class="center"><a href="{!! $translate->token('clt_cli_link_callus') !!}">{!! $translate->token('clt_cli_link_textcallus') !!}</a></p>	
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-cell">
					<div class="text-block">
						<div class="feature-icon icon-scent"></div>
						<h3>{!! $translate->token('clt_cli_h_scentdevelopment') !!}</h3>
						<p>{!! $translate->token('clt_cli_text_scentdevelopment') !!}</p>
						<p class="center"><a href="{!! $translate->token('clt_cli_link_scentdevelopment') !!}"> {!! $translate->token('clt_cli_link_textscentdevelopment') !!}</a></p>	
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>

@stop
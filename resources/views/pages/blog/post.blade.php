@section('bodyClass', 'blog')
@section('currentNav', 4)

@extends('layouts.pages')

@section('content')

<div class="container">
	
	<div class="content-block">
		<div class="container">
			<div class="text-block">
				<h2>{{ $blogPost->blg_title }}</h2>
			</div>
		</div>
	</div>
		
	<div class="content-block">
		
		<!-- Blog Header -->
		<div class="grid large post-header">
			
			<div class="box">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-label">
								<h3>{{ date('d F, Y', strtotime($blogPost->blg_date)) }}</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="box">
				<div class="box-cell">
					<div class="tile">
						<div class="tile-content">
							<div class="tile-image">
								<img alt="{{ $blogPost->blg_title }}" src="{{ $blogPost->blg_hero }}" />
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>

		<div class="post">
			{!! $blogPost->blg_content !!}
		</div>
		<div style="clear: both"></div>
	</div>
	
</div>

<div class="content-block cb-b blog-footer">
	<div class="container">
		<div class="text-block">
			<div class="grid large">
				<div class="box">
					<div class="text-block">
						<h3>{!! $translate->token('h_share') !!}</h3>
						<ul class="share-list" style="display: none">
							<!-- Facebook Button -->
							<li class="facebook">
								<div class="fb-like" data-href="{{ Request::url() }}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
							</li>
							<!-- Google Plus Button -->
							<li class="google">
								<g:plusone></g:plusone>
							</li>
							<!-- Twitter Button -->
							<li class="twitter">
								<a href="https://twitter.com/share" class="twitter-share-button"{count}>Tweet</a>
							</li>
							<!-- Pinterest Button -->
							<li class="pinterest">
								<a data-pin-do="buttonBookmark" href="https://www.pinterest.com/pin/create/button/">
									<img width="60px" height="40px" src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" />
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="box">
					<div class="text-block">
						<h3>{!! $translate->token('h_filedunder') !!}</h3>
							<ul class="tag-list">
								@foreach ($tags as $tag) 
									<li><a rel="nofollow" href="{{ $link->create('/blog/tag')->url() }}/{{ trim($tag->site_slug ?: $tag->base_slug) }}">{{ $tag->site_name ?: $tag->base_name }}</a></li>
								@endforeach
							</ul>
						</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Twitter SDK -->
<script async defer src="/scripts/twitter.js"></script>
<!-- Facebook SDK -->
<script async defer src="/scripts/facebook.js"></script>
<!-- Pintrest JS -->
<script async defer src="//assets.pinterest.com/js/pinit.js"></script>
<!-- Google Plus JS -->
<script async defer src="//apis.google.com/js/plusone.js"></script>

@stop
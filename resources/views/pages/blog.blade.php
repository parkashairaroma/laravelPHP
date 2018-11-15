@section('bodyClass', 'blog')
@section('currentNav', 4)

@extends('layouts.pages')

@section('content')

<div class="container">
	
	<div class="content-block">
		
		{{-- Commented out by request - contact Alan for further information
			<!-- Aromagram -->	
			@include('pages.partials.blog-aromagram', ['id' => 0])
		--}}

		<!-- Blog Posts -->
		@foreach ($blogs as $key => $blog)

		@if (($key % 2) == 0) 
			<div class="grid large divider blog">
		@endif


			<div class="box">
				<div class="blog-cell">
					<div class="blog-content">
						<div class="text-block">
							<h3><a href="{!! $link->create('/blog')->url() !!}/{{ $blog->blg_slug }}">{{ $blog->blg_title }}</a></h3>
							<p> {!! paragraph($blog->blg_content) !!} </p>
							<p><a href="{!! $link->create('/blog')->url() !!}/{{ $blog->blg_slug }}">{!! $translate->token('link_readmore') !!}</a></p>
						</div>
					</div>
					<div class="blog-image"><a href="{!! $link->create('/blog')->url() !!}/{{ $blog->blg_slug }}"><img alt="{{ $blog->blg_title }}" src="{{ $blog->blg_hero }}" /></a></div>
				</div>
			</div>

		@if (($key % 2) == 1 || count($blogs) == ($key+1))
			</div>

			{{-- Commented out by request - contact Alan for further information
			@if ($counter++ == 0) 
				<!-- Aromagram -->	
				@include('pages.partials.blog-aromagram', ['id' => 1])
			@endif
			--}}
		@endif

		@endforeach

		<!-- Navigation --> 
		@if (! $blogs->previousPageUrl()) 
			<div class="grid more hairline">
				@include('pages.partials.blog-older-posts')
			</div>
		@elseif (! $blogs->hasMorePages())
			<div class="grid more hairline">
				@include('pages.partials.blog-newer-posts')
			</div>
		@else
			<div class="grid grid-pagination hairline">
				@include('pages.partials.blog-newer-posts')
				@include('pages.partials.blog-older-posts')
			</div>
		@endif
		
	</div>
	
</div>

@stop
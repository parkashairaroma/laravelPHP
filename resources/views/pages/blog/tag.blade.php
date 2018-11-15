@section('bodyClass', 'blog')
@section('currentNav', 4)

@extends('layouts.pages')

@section('content')

<div class="hero-block hb-a hb-c">
	<div class="container">
		<div class="hero-content">
			<h3>Posts with tag: &ldquo;{{ $tag }}&rdquo;<br>{{ $posts->count() }} results found</h3>
		</div>
	</div>
</div>

<div class="container">

	@foreach ($posts as $post)
	<div class="content-block cb-a post-result">
		<div class="text-block">
			<h3><a href="/blog/{{ $post->blg_slug}}">{{ $post->blg_title }}</a></h3>
			<p>{{ date('d F, Y', strtotime($post->blg_date)) }}</p>
		</div>
	</div>
	@endforeach
	
	{{--- @byron removed for now
	<div class="content-block">
		<div class="text-block">
			<div class="pagination">
				<p class="link-button lb-prev"><a href="#">Newer</a></p>
				<p class="link-button lb-next"><a href="#">Older</a></p>
			</div>
		</div>
	</div>
	---}}

</div>

@stop
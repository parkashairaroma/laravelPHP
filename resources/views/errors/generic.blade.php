@section('titleTag', 'Page Not Found')
@section('descriptionTag', 'Page Not Found')
@section('keywordsTag', 'Air Aroma')

@extends('layouts.pages')

@section('content')

<div class="container">
	<div style="padding: 150px; text-align: center">{!! $translate->token('text_siteissue') !!}</div>
</div>

@stop
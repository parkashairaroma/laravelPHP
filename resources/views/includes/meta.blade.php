{{-- touch devices --}}
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="/images/favicon/apple-touch-icon-57x57.png" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/images/favicon/apple-touch-icon-114x114.png" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/images/favicon/apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/images/favicon/apple-touch-icon-144x144.png" />
<link rel="apple-touch-icon-precomposed" sizes="60x60" href="/images/favicon/apple-touch-icon-60x60.png" />
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="/images/favicon/apple-touch-icon-120x120.png" />
<link rel="apple-touch-icon-precomposed" sizes="76x76" href="/images/favicon/apple-touch-icon-76x76.png" />
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="/images/favicon/apple-touch-icon-152x152.png" />
<link rel="icon" type="image/png" href="/images/favicon/favicon-196x196.png" sizes="196x196" />
<link rel="icon" type="image/png" href="/images/favicon/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/png" href="/images/favicon/favicon-32x32.png" sizes="32x32" />
<link rel="icon" type="image/png" href="/images/favicon/favicon-16x16.png" sizes="16x16" />
<link rel="icon" type="image/png" href="/images/favicon/favicon-128.png" sizes="128x128" />

{{-- meta --}}
<meta name="application-name" content="&nbsp;"/>
<meta name="msapplication-TileColor" content="#FFFFFF" />
<meta name="msapplication-TileImage" content="/images/favicon/mstile-144x144.png" />
<meta name="msapplication-square70x70logo" content="/images/favicon/mstile-70x70.png" />
<meta name="msapplication-square150x150logo" content="/images/favicon/mstile-150x150.png" />
<meta name="msapplication-wide310x150logo" content="/images/favicon/mstile-310x150.png" />
<meta name="msapplication-square310x310logo" content="/images/favicon/mstile-310x310.png" />
@if (trim($__env->yieldContent('keywordsTag'))) 
	<meta name="keywords" content="{{ trim($__env->yieldContent('keywordsTag')) }}">
@else
	<meta name="keywords" content="{!! $translate->token('tag_keywords', false) !!}">
@endif 
<meta name="author" content="Air Aroma">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="index,follow">
<meta property="og:url" content="{{ Request::url() }}" />
<meta property="og:type" content="article" />

@if (isset($blogTitle))
	<meta property="og:image" content="{{ url($blogImage) }}" />
	<meta property="og:title" content="{{ $blogTitle }}" />
	<meta property="og:description" content="{{$blogSummary }}" />
@else

@if (isset($storeImage))

<meta property="og:image" content="{{ url($storeImage) }}" />

@else

<meta property="og:image" content="{{ url('images/airaroma-logo.png') }}" />

@endif

@if (trim($__env->yieldContent('descriptionTag')))
<meta name="og:title" content="{{ trim($__env->yieldContent('titleTag')) }}" />
@else
<meta property="og:title" content="{{$translate->token('tag_title', false) }}" />
@endif

@if (isset($clientDesc))

<meta property="og:description" content="{{$clientDesc }}" />

@else

@if (trim($__env->yieldContent('descriptionTag')))
<meta property="og:description" content="{{ trim($__env->yieldContent('descriptionTag')) }}" />
@else
<meta property="og:description" content="{{ $translate->token('tag_description', false) }}" />
@endif 

@endif

	
@endif


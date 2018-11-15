<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>
			@if (isset($blogTitle)) 
				{{$blogTitle }} - {{websitetitle() }}
   @elseif (isset($clientPost) && isset($clientPost->clt_cli_title))
     {{$clientPost->clt_cli_title }} - {{websitetitle()}}
			@else
				@if (trim($__env->yieldContent('titleTag'))) 
					@yield('titleTag') - {{ websitetitle() }}
				@else
      @if (Request::is('store') || Request::is('store/*')) 
      {{ $translate->token('tag_title', false) }}
      @else
        {{$translate->token('tag_title', false) }} - {{ websitetitle() }}
      @endif
				@endif 
			@endif
		</title>
		
		@if (isset($blogTitle)) 
			<meta  name="description" content="{{ $blogTitle }}">
		@else
			@if (trim($__env->yieldContent('descriptionTag'))) 
				<meta name="description" content="{{trim($__env->yieldContent('descriptionTag')) }}">
			@else
				<meta name="description" content="{{ $translate->token('tag_description', false) }}">
			@endif 
		@endif

		@include('includes.meta')

		{{-- Styles --}}
		{!! Html::style('/scripts/slick/slick.css') !!}
		{!! Html::style('/scripts/semantic/transition.min.css') !!}
		{!! Html::style('/scripts/semantic/dropdown.min.css') !!}
		{!! Html::style('/scripts/semantic/search.min.css') !!}
		{!! Html::style('/css/style.css?'.time()) !!}
		{!! Html::style('/css/fixes.css?'.time()) !!}


		{{-- Administration --}}
		@if (auth()->guard('admin')->check())
			{!! Html::style('/cp/css/frontend.css?'.time()) !!}
   			{!! Html::style('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css') !!}
    		{!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/tooltipster/3.3.0/css/tooltipster.min.css') !!}
		@endif

    	{!! Html::script('/scripts/jquery-2.2.4.min.js') !!}
    	{!! Html::script('/scripts/jquery-ui-1.11.4.min.js') !!}
	 	{!!Html::script('/cp/js/library.js') !!}
	</head>


	{{-- Determine if we are working on the develop branch --}}
	@if ($branch)
		<div class="developer-branch {{ $branch }} ">
			<span class="text">{{ substr(ucwords($branch), 0, 1) }}</span>
		</div>
	@endif

	<body @if(trim($__env->yieldContent('bodyClass'))) class="@yield('bodyClass')" @endif>
		<header role="banner">
			<div class="container">
				<div id="menu-button">
					<span id="menu-button-icon">
						<span class="ml" id="ml-01"></span>
						<span class="ml" id="ml-02"></span>
						<span class="ml" id="ml-03"></span>
					</span>
				</div>
				<div id="logo">
					<h1><a href="/" title="Home"><span>Air Aroma</span></a></h1>
				</div>


    {{-- If Store is Enable --}}
             @if ($enableStore) 
				        {{-- Enable Store --}}
					        <div id="cart-button" @if ($cartProductCount) class="has-item" @endif>
						        <a href="#"><span class="cart-icon"></span></a>
					        </div>

				        {{-- Enable Store --}}
				        @if ($branch != 'master')
					        <div id="nav-account" class="navigation">
						        <span class="caret"></span>
						        <ul class="nav-account-list">
							        <li><a href="/store/cart">Cart (<span id="store-count">{{ $cartProductCount }}</span>)</a></li>
							        @if ($authedStoreUser)
								        <li><a href="/store/account">Account</a></li>
								        <li><a href="/store/account/orders">Orders</a></li>
								        <li><a href="/store/signout">Sign out {{ $authedStoreUser->acc_firstname }}</a></li>
							        @else
								        <li><a href="/store/signin">Sign in / Sign up</a></li>
							        @endif
						        </ul>
						        @if ($cartProductCount)
							        <a href="/store/checkout" class="ui-button checkout-button"><span class="button-icon button-icon-lock"></span>Checkout</a>
						        @else
							        <a herf="#" class="ui-button button-disabled checkout-button" disabled><span class="button-icon button-icon-lock"></span>Checkout</a>
						        @endif
					        </div>
				        @endif
					@endif

			</div>
		</header>
		<nav role="navigation" id="nav-primary" class="navigation">
			<div class="container">
			<ul class="nav-list">
				<li<?php echo ($__env->yieldContent('currentNav') == 1 ? ' class="active"' : ''); ?> id="nav-scent-marketing">{!! $link->create('/scent-marketing')->full('nav_scenting') !!}</li>
				<li<?php echo ($__env->yieldContent('currentNav') == 2 ? ' class="active"' : ''); ?> id="nav-products">{!! $link->create('/products')->full('nav_products') !!}</li>
				<li<?php echo ($__env->yieldContent('currentNav') == 3 ? ' class="active"' : ''); ?> id="nav-clients">{!!$link->create('/clients')->full('nav_clients') !!}</li>
    @if (websiteId() != 5)     <!-- For Dutch site to remove Blog -->   
				<li<?php echo ($__env->yieldContent('currentNav') == 4 ? ' class="active"' : ''); ?> id="nav-blog">{!! $link->create('/blog')->full('nav_blog') !!}</li>
    @endif
				<li<?php echo ($__env->yieldContent('currentNav') == 5 ? ' class="active"' : ''); ?> id="nav-contact">{!!$link->create('/contact')->full('nav_contact') !!}</li> 

				@if ($enableStore)  
					<li<?php echo ($__env->yieldContent('currentNav') == 6 ? ' class="active store"' : ' class="store"'); ?> id="nav-store">{!! $link->create('/store')->full('nav_store') !!}</li>
				@endif

			</ul>
			</div>
		</nav>
		<main role="main">
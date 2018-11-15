@section('titleTag', 'Style Guide')
@section('bodyClass', 'guide subnav')
@section('currentNav', 0)
@section('currentSubNav', 1)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-guide')


<div class="hero-block hb-a">
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>Air Aroma Style Guide</h1>
				<p>A reference list of text based elements. Includes headings, paragraphs, lists and block quotes.</p>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="content-block cb-a">
		<div class="text-block">
			<h3>Headings</h3>
			<h1>H1: The quick brown fox jumped over the lazy dog</h1>
			<h2>H2: The quick brown fox jumped over the lazy dog</h2>
			<h3>H3: The quick brown fox jumped over the lazy dog</h3>
			<h4>H4: The quick brown fox jumped over the lazy dog</h4>
		</div>	
	</div>
	<div class="content-block">
		<div class="text-block">
			<h3>Text Blocks</h3>
			<p>A standard <code>.text-block</code> aligns <code>h4, p, ul &amp; ol</code> elements to the left. <a href="#">Here is a basic text-link</a>, ei nisl lorem mei, sea error civibus cu. Ea facer omnes vocent vis, has qualisque sententiae efficiendi ad, cibo liber definiebas ut duo. Cu meliore maiestatis contentiones nam. Cetero dissentiet ex his, justo salutatus id duo. Et quod dicit theophrastus mea, ei sea feugait mentitum. Ad fuisset facilisi ius, ad duo cetero tractatos.</p>
			<h4>Modifiers</h4>
			<ul>
				<li><code>.tb-a</code> center-aligns text.</li>
				<li><code>.tb-b</code> doubles the vertical padding of a text block.</li>
				<li><code>.tb-c</code> removes bottom padding to allow images to be aligned to the bottom of a block.</li>
			</ul>
			<h4>Lists</h4>
			<ul>
				<li>Scent Marketing</li>
				<li>Products</li>
				<ul>
					<li>Aromax</li>
					<li>Aropromo</li>
					<li>Signature Scents</li>
				</ul>
				<li>Clients</li>
			</ul>
			<ol>
				<li>Scent Marketing</li>
				<li>Products</li>
				<li>Clients</li>
			</ol>
			<p>Ea facer omnes vocent vis, has qualisque sententiae efficiendi ad, cibo liber definiebas ut duo. Cu meliore maiestatis contentiones nam. Cetero dissentiet ex his, justo salutatus id duo. Et quod dicit theophrastus mea, ei sea feugait mentitum. Ad fuisset facilisi ius, ad duo cetero tractatos.</p>
		</div>
	</div>
	<div class="content-block cb-b">
		<div class="text-block">
			<blockquote class="pull">
				<h4>Blockquote</h4>
				<p>&ldquo;Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam&rdquo;</p>
				<footer>Quote Author</footer>
			</blockquote>
		</div>
	</div>
	<div class="content-block cb-a">
		<div class="text-block">
			<p>Ea facer omnes vocent vis, has qualisque sententiae efficiendi ad, cibo liber definiebas ut duo. Cu meliore maiestatis contentiones nam. Cetero dissentiet ex his, justo salutatus id duo. Et quod dicit theophrastus mea, ei sea feugait mentitum. Ad fuisset facilisi ius, ad duo cetero tractatos.</p>
		</div>
	</div>
	<div class="content-block cb-a">
		<div class="text-block">
			<h3>Content Blocks</h3>
			<p>A <code>.content-block</code> is a generic wrapper for a block of any type content. Use it to break pages up into sections that can be styled or edited independently.</p>
			<h4>Modifiers</h4>
			<ul>
				<li><code>.cb-a</code> adds a bottom border to the block.</li>
				<li><code>.cb-b</code> changes the background colour to grey for highlighting content, such as block quotes.</li>
				<li><code>.cb-c</code> changes the background colour to black.</li>
				<li><code>.cb-network</code> is a custom block for the Global Network block in <a href="/why-air-aroma">Why Air Aroma</a>.</li>
			</ul>
		</div>
	</div>
	<div class="content-block">
		<div class="text-block">
			<h3>Hero Blocks</h3>
			<p>A <code>.hero-block</code> is a full-width wrapper for the main banners across most pages. Hero block images can be set per page via <span class="file">_hero.scss</span></p>
			<h4>Modifiers</h4>
			<ul>
				<li><code>.hb-a</code> adds a bottom border to the block.</li>
				<li><code>.hb-b</code> changes the background colour to grey.</li>
				<li><code>.large</code> creates a larger hero block for large images.</li>
			</ul>
			<p>For hero blocks with dark backgrounds and light text, apply the <code>.dark</code> to the <code>body</code> tag.</p>
		</div>
	</div>
</div>

@stop
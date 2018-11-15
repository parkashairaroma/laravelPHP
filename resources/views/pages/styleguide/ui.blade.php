@section('titleTag', 'Style Guide - UI Elements')
@section('bodyClass', 'guide subnav')
@section('currentNav', 0)
@section('currentSubNav', 4)

@extends('layouts.pages')

@section('content')

{{-- Navigation --}}
@include('includes.nav.nav-guide')

<div class="hero-block hb-a">
	<div class="container">
		<div class="hero-content">
			<div class="text-block">
				<h1>UI Elements</h1>
				<p>Buttons and form elements.</p>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="content-block cb-a">
		<div class="text-block">
			<h3>Buttons</h3>
			<p>Turn turn a standard link into a button, use the <code>.link-button</code> class.</p>
			<h4>Modifiers</h4>
			<ul>
				<li><code>.lb-a</code> aligns buttons to center.</li>
				<li><code>.lb-b</code> dark background with light text.</li>
			</ul>
			<p class="link-button"><a href="#">Button</a></p>
			<p class="link-button lb-b"><a href="#">Button</a></p>
		</div>
	</div>
	<div class="content-block">
		<div class="text-block">
			<h3>Forms</h3>
			
			<form>
				<div class="form-group">
					<label>Single line text input</label>
					<input type="text" id="contact-name">
				</div>
				<div class="form-group">
					<label>Multiple line text input</label>
					<textarea rows="8"></textarea>
				</div>
				<div class="form-group">
					<label>Select Dropdown</label>
					<select id="contact-country">
						<option>Option</option>
					</select>
				</div>
				<div class="form-action">
					<input type="submit" value="Send">
				</div>
			</form>
			
		</div>
	</div>
</div>

@stop
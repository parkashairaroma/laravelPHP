<div style="font-size: 11px; font-family: Helvetica Neue, Arial, sans-serif; line-height: 15px;">
	<p>{!! $translate->token('contactform_hello', false) !!} {{ $data['contactName'] }},</p>
	<p>{!! $translate->token('contactform_message', false) !!}</p>
	<img src="{{ $data['emailImageServer'] }}/images/logo-aai2016.jpg" style="margin: 0 0 0 10px;"><br /><br />
	<p style="margin: 0 0 15px 0; padding: 0 10px;">
		<a href="http://twitter.com/#!/AirAroma" target="_blank" style="text-decoration: none; color: #000000;"><img src="{{ $data['emailImageServer'] }}/images/social-twitter-18.png" border="0" style="vertical-align: top; margin: -3px 6px 0 0;" />{!! $translate->token('contactform_follow', false) !!} Air Aroma</a> {!! $translate->token('contactform_on', false) !!} Twitter
		<a href="http://www.facebook.com/AirAroma" target="_blank" style="text-decoration: none; color: #000000;"><img src="{{ $data['emailImageServer'] }}/images/social-facebook-18.png" border="0" style="vertical-align: top; margin: -3px 6px 0 20px;" />{!! $translate->token('contactform_like', false) !!} Air Aroma</a> {!! $translate->token('contactform_on', false) !!} Facebook
	</p>
</div>
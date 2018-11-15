<div style="font-size: 11px; font-family: Helvetica Neue, Arial, sans-serif; line-height: 15px;">
	<p>A new message was received from the Website Contact Form (on website {{ $data['contactWebsiteName'] }})</p>
	<p>Date: {{ $data['contactDate'] }}</p>
	<p>Name: {{ $data['contactName'] }}</p>
	<p>Email: {{ $data['contactEmailAddress'] }}</p>
	<p>Phone: {{ $data['contactPhone'] }}</p>
	<p>Newsletter: {{ $data['contactNewsletter'] }}</p>
	<p>Selected Country: {{ $data['contactSelectedCountry'] }}</p>
	<p>Detected Country: {{ $data['contactDetectedCountry'] }}</p>
	<p>State: {{ $data['contactState'] }}</p>
	<p>Reason: {{ $data['contactReason'] }}</p>
	<p>Message: {{ $data['contactMessage'] }}</p>
</div>
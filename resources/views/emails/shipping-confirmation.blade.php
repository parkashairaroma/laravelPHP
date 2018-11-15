@extends('emails.layouts.base')

@section('content')
<p>Dear {{ $firstName }} {{$lastName }},</p>
<p>Just a quick email to let you know that we've shipped your order <b>{{ $orderNumber }}</b> and it should be arriving shortly.</p>
<p>Your order has been shipped with consignment tracking number: <strong>{{$trackingNumber }}</strong></p>
<p>You can track the delivery status of your order at:</p>
<p>{{ $trackingLink }}</p>
<p>Best Regards,</p>
<p>Air Aroma</p>
<p>This transmission may be privileged and may contain confidential information intended only for the person(s) named above. Any other distribution, re-transmission, copying or disclosure is strictly prohibited. If you have received this transmission in error, please notify us immediately by telephone or email, and delete this file/message from your system.</p>
@stop
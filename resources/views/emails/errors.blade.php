<pre>

Host:
{{ $data->host }}
{{ $data->hostIp }}

Request:
{{ $data->method }}: {{ $data->url }}
{{ $data->timeStamp }}

Referrer:
{{ $data->referrer }}

Client IP:
https://who.is/whois-ip/ip-address/{{$data->ip }}

Client Email Address:
{{ $data->clientemail }}

Browser Details:
---------------

Browser Name : {{ $data->browserName }}
Browser Version : {{ $data->browserVersion }}
<?php
if ($data->browserIsMobile)
echo "Device : Mobile <br />";
else if ($data->browserIsDesktop)
echo "Device : Desktop <br />";
else if ($data->browserIsTablet)
echo "Device : Tablet <br />";
?>
Browser IsBot : {{ $data->browserIsBot }}
Platform Name : {{ $data->browserPlatName }}
Platform Version  : {{ $data->browserPlatVersion }}
Browser Device : {{ $data->browserDeviceFamily }}
Browser Device Model : {{ $data->browserDeviceModel }}
Browser HTTP User Agent : {{ $data->browserUserAgent }}

Exception:
{{ $data->exception }}

</pre>
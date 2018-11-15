<!DOCTYPE html>
<html>
    <head>
        <title>{{ $siteConfig['web_title'] }}</title>
        {!! Html::style('/css/style.css?'.time()) !!}
        {!! Html::style('/css/fixes.css?'.time()) !!}
    </head>
    <body class="translating">
        <div class="container">
            <div class="content">
                <div class="title">
                    {{ $siteConfig['web_title'] }} launching soon.
                </div>
            </div>
        </div>
    </body>
</html>

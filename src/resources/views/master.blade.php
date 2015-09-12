<!DOCTYPE html>
<html lang="en">
<head>
    {!! SEO::generate() !!}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">

    {{-- css de una libreria en alguna vista --}}
    @yield('css')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
@include('partials.header')
@include('partials.navbar')

<div class="container flashes">
    @include('flash::message')
</div>

@yield('content')

@include('partials.footer')

<!-- javascript -->
{{-- analytics --}}
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', '{!! env('GOOGLE_ANALYTICS_ID') !!}', 'auto');
    ga('send', 'pageview');
</script>

<script src="{{ elixir('js/all.js') }}"></script>

@yield('js')

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Meta -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <!-- Title -->
    <title>{{ App::make('option')->getOPtionVal('sitename') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Raleway:wght@100;200;400;500&display=swap" rel="stylesheet">

    <!-- CSS Core -->
    <link rel="stylesheet" href="{{ asset('dist/css/core.css') }}" />

    <link rel="stylesheet" href="{{ asset('dist/css/custom.css') }}" />
    <!-- CSS Theme -->
    <link id="theme" rel="stylesheet" href="{{ asset('dist/css/theme-beige.css') }}" />

    @if(App::getLocale()=='ar')
    <link rel="stylesheet" href="{{ asset('dist/css/rtl.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}">
    @php
       $fontfamily =  App::make('option')->getOPtionVal('fontfamily')
    @endphp
    <?php echo "<style>body{font-family:".$fontfamily."}</style>";?>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>

<script>
  // Nice Select JS
  $(document).ready(function() {
    $('select').niceSelect();
  });
</script>

</head>

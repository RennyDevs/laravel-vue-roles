<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

{{-- CSRF Token --}}
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="url" content="{{ config('app.url') }}">

<title>@yield('title'){{ config('app.name') }}</title>

{{-- Styles --}}
<link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
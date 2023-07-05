<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
@include('backend.includes.head')
<body  id="Container">
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <!-- Navbar -->
        <nav  class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ">
            <!-- Navbar Search -->
            <li class="nav-item mt-1">
                <form action="{{ route('logout') }}" method="POST">
                @csrf
                    <button class="btn btn-xs btn-outline-light text-primary" type="submit"><img src="{{ asset('icon/logout.png')}}" width="28">{{ __('Log Out') }}</button>
                </form>
            </li>

            </ul>
            <ul class="nav nav-tabs "  id="myTab" role="tablist">

                @foreach (App::make('languages') as $key => $lang)
                    <li class="nav-item">
                        <a class="nav-link tab text-dark @if ($loop->index == 0)  @endif"
                            id="home-tab" href="{{ route('dashboard',['locale'=>$key])}} " role="tab"
                            aria-controls="home" aria-selected="true">{{ $lang }}</a>
                    </li>
                @endforeach


                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        @include('backend.includes.sidebar')
            <div class="content-wrapper" >
                <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-5">
                        @yield('content')
                    </div>
                </div>
                </div>
            </div>
    </div>
  @include('backend.includes.footer')
  @include('backend.includes.scripts')
</body>
</html>

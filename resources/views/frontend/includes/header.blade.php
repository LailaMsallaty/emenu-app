<!-- Header -->
<header id="header" class="light">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <!-- Logo -->
                <div class="module module-logo dark">
                    <a href="{{ route('app.index') }}">
                        @if(App::make('option')->getOPtionVal('logo_img') !=='')
						 <img src="{{ asset('storage/headers/'.App::make('option')->getOPtionVal('logo_img')) }}" alt="">
                        @else
                         <img src="{{ asset('images/Restaurant.jpg') }}" alt="">
                        @endif
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <!-- Navigation -->
                <nav class="module module-navigation left">
                    <ul id="nav-main" class="nav nav-main">
                        <li>
                            <a
                            href="{{ route('app.index') }}"
                            class="btn btn-outline-secondary"><span>{{ __('Menu')  }}</span>
                            </a>
                        </li>
                     @foreach (App::make('pages') as $page )
                        <li><a href="{{ route('app.index',['page'=>'cms','id'=>$page->id]) }}" class="btn btn-outline-secondary"><span>{{ $page->getTranslation('page_title', App::getLocale()); }}</span></a></li>
                     @endforeach

                    </ul>
                </nav>
            </div>
                <div class="col-md-1 module module-lang left">
                    <div class="langbar"style="font-weight: bold; margin-top:4px">
                        {{-- @foreach (App::make('languages') as $key => $lang)
                            <a href="{{ route('app.index',['locale'=>$key])}}"
                                 @if ($key == App::getLocale()) hidden @endif
                             >{{ $lang }}
                            </a>
                        @endforeach --}}
                        <select class="optionLang">
                            @foreach (App::make('languages') as $key => $lang)
                              <option  data-value="{{ $lang }}" @if ($key == App::getLocale()) selected @endif data-link="{{ route('app.index',['locale'=>$key])}}">
                                {{ $lang }}
                              </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <a href="#" class="col-md-2  module module-cart right" data-toggle="panel-cart" style="display:none;">
                    <span class="cart-icon">
                        <i class="ti ti-shopping-cart" style="margin-left: 30px;"></i>
                        <span class="notification">0</span>
                    </span>
                    <span class="cart-value">{{ App::make('option')->getOPtionVal('currencysymbol') }}<span class="value">0.00</span></span>
                </a>
        </div>
    </div>

</header>
<!-- Header / End -->
<!-- Header -->
<header id="header-mobile" class="light">

    <div class="module module-nav-toggle">
        <a href="#" id="nav-toggle" data-toggle="panel-mobile"><span></span><span></span><span></span><span></span></a>
    </div>
    <div class="module module-logo">
        <a href="index.php">
            <!-- <img src="./images/logo-horizontal.png" alt=""> -->
            @if(App::make('option')->getOPtionVal('logo_img') !=='')
              <img width="80" height="100" src="{{ asset('storage/headers/'.App::make('option')->getOPtionVal('logo_img')) }}" alt="">
            @else
              <img width="80" height="100" src="{{ asset('images/Restaurant.jpg') }}" alt="">
            @endif
        </a>
        <div class="module module-lang right" style="margin-top:4px;margin-right: 5px; float:right;font-weight: bold;">
            {{-- @foreach (App::make('languages') as $key => $lang)
              <a href="{{ route('app.index',['locale'=>$key])}}" @if ($key == App::getLocale()) hidden @endif>{{ $lang }}</a>
            @endforeach --}}
            <select class="optionLang">
                @foreach (App::make('languages') as $key => $lang)
                  <option  data-value="{{ $lang }}" @if ($key == App::getLocale()) selected @endif data-link="{{ route('app.index',['locale'=>$key])}}">
                    {{ $lang }}
                  </option>
                @endforeach
            </select>
        </div>
    </div>
    <div>
<div>
    <a href="#" class=" module module-cart" data-toggle="panel-cart" style="display:none;">
        <i class="ti ti-shopping-cart"></i>
        <span class="notification" data-cart-qty>2</span>
    </a>
</div>
</header>
<!-- Header / End -->

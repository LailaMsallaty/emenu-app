<!-- Panel Cart -->
<div id="panel-cart">
    <div class="panel-cart-container">
        <div class="panel-cart-title">
            <h5 class="title titlecaption"></h5>
            <button class="close" data-toggle="panel-cart"><i class="ti ti-close"></i></button>
        </div>
        <div class="panel-cart-content cart-details">
            <table class="cart-table">

            </table>
            <div class="cart-summary">
                <div class="row" id="cart-products-total-container">
                    <div class="col-7 text-right text-muted">{{ __('Order total') }} :</div>
                    <div class="col-5"><strong>{{ App::make('option')->getOPtionVal('currencysymbol') }}<span class="cart-products-total">0.00</span></strong></div>
                </div>
                <div class="row" id="cart-delivery-container">
                    <div class="col-7 text-right text-muted">{{ __('Devliery')  }} :</div>
                    <div class="col-5"><strong>{{ App::make('option')->getOPtionVal('currencysymbol') }}<span class="cart-delivery">0.00</span></strong></div>
                </div>
                <hr class="hr-sm" id="cart-summary-line">
                <div class="row text-lg">
                    <div class="col-7 text-right text-muted">{{ __('Order total') }} :</div>
                    <div class="col-5"><strong>{{ App::make('option')->getOPtionVal('currencysymbol') }}<span class="cart-total">0.00</span></strong></div>
                </div>
            </div>
            <div class="cart-empty">
                <i class="ti ti-shopping-cart"></i>
                <p>{{ __('Your cart is empty') }}...</p>
            </div>
        </div>
    </div>
    <a href="{{ route('app.index',['page'=>'placeorder']) }}" class="panel-cart-action btn btn-secondary btn-block btn-lg"><span> {{ __('Place order') }} </span></a>
</div>
<!-- Panel Mobile -->
<nav id="panel-mobile">
    <div class="module module-logo bg-dark dark">
        <a href="#">
            <!-- <img src="./images/logo.png" alt="" width="125"> -->
            @if(App::make('option')->getOPtionVal('logo_img') !=='')
              <img width="200" height="300"  src="{{ asset('storage/headers/'.App::make('option')->getOPtionVal('logo_img')) }}" alt="">
            @else
              <img width="200" height="300" src="{{ asset('images/Restaurant.jpg') }}" alt="">
            @endif
        </a>
        <button class="close" data-toggle="panel-mobile"><i class="ti ti-close"></i></button>
    </div>
    <nav class="module module-navigation"></nav>
    <div class="module module-social">
        <h6 class="text-sm mb-3">Follow Us!</h6>
        <a href="#" class="icon icon-social icon-circle icon-sm icon-facebook"><i class="fa fa-facebook"></i></a>
        <a href="#" class="icon icon-social icon-circle icon-sm icon-google"><i class="fa fa-google"></i></a>
        <a href="#" class="icon icon-social icon-circle icon-sm icon-instagram"><i class="fa fa-instagram"></i></a>
    </div>
</nav>

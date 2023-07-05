<x-frontend>
@php
    Session::put('token',uniqid());
@endphp
<section class="section bg-light">
  <div class="container">
          <div class="row">
                    <div class="col-xl-4 col-lg-5">
                        <div class="cart-details shadow bg-white stick-to-content mb-4">
                            <div class="bg-dark dark p-4"><h5 class="mb-0">{{ __('Your order')}}</h5></div>
                            <table class="cart-table">

                            </table>
                            <div class="cart-summary">
                                <div class="row" id="cart-products-total-container">
                                    <div class="col-7 text-right text-muted">{{ __('Order total') }} :</div>
                                    <div class="col-5"><strong>{{ App::make('option')->getOptionVal('currencysymbol') }}<span class="cart-products-total">0.00</span></strong></div>
                                </div>
                                <div class="row" id="cart-delivery-container" >
                                    <div class="col-7 text-right text-muted"> {{ __('Devliery') }} :</div>
                                    <div class="col-5"><strong>{{ App::make('option')->getOptionVal('currencysymbol') }}<span class="cart-delivery">0.00</span></strong></div>
                                </div>
                                <hr class="hr-sm" id="cart-summary-line">
                                <div class="row text-lg">
                                    <div class="col-7 text-right text-muted">  {{ __('Total') }} :</div>
                                    <div class="col-5"><strong>{{ App::make('option')->getOptionVal('currencysymbol') }}<span class="cart-total">0.00</span></strong></div>
                                </div>
                            </div>
                            <div class="cart-empty">
                                <i class="ti ti-shopping-cart"></i>
                                <p>Your cart is empty...</p>
                            </div>
                        </div>
                    </div>

                <div class="col-xl-8 col-lg-7 order-lg-first">
                    <div class="bg-white p-4 p-md-5 mb-4">
                                <h4 class="border-bottom pb-4"><i class="ti ti-user mr-3 text-primary"></i> {{ __('Basic information') }}</h4>
                                <div class="row mb-5">
                                <div class="form-group col-sm-12">
                                    @if(App::make('option')->getOPtionVal('activatetables') =='1')
                                    @if(App::make('option')->getOPtionVal('enforcetablespreselection') =='1')
                                        <h4>{{ __('Table') }} : {{ Session::get('tablecode') }}</h4>
                                        <input id="table" type="hidden" class="orderforminput" value="{{ Session::get('tablecode') }}"/>
                                    @else
                                    <label>{{ __('Table') }} : </label>
                                    <div class="select-container">
                                        <select id="table" class="form-control orderforminput">
                                            @php $tbs = explode(',',App::make('option')->getOPtionVal('tblcodes')) @endphp
                                            @foreach ($tbs as $row)
                                                <option {{ ($row==Session::get('tablecode'))?'selected':'' }}>{{ $row }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                    @endif
                                </div>
                                <div class="form-group col-sm-12">
                                        <label> {{ __('Name') }} :</label>
                                        <input id="name" type="text" class="form-control orderforminput" value="{{ Cookie::get('username') }}">
                                    </div>
                                </div>
                    </div>
                  <div class="text-center">
                      <input id="token" type="hidden" class="orderforminput" value="{{  Session::get('token') }}"/>
                      <button data-url="{{ route('orderStore') }}"  class="btn btn-primary btn-lg order-submit" id="order-submit"><span> {{ __('order Now') }} </span></button>
                  </div>
                </div>

        </div>
  </div>
</section>
</x-frontend>


<!-- Page Title -->
@if (Session::get('currentpage')=='menu_list')

        <div class="page-title bg-light">
            <div class="bg-image bg-parallax">
               @if(App::make('option')->getOPtionVal('banner_img') !=='')
                <img src="{{ asset('storage/headers/'.App::make('option')->getOPtionVal('banner_img')) }}" alt="">
               @else
                <img src="{{ asset('images/menu.jpg') }}" alt="">
               @endif
			</div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-4">
                        <h1 class="mb-0 text-white font-weight-normal">{{ __('MENU List') }}   </h1>
                        <h4 class="text-muted mb-0 font-weight-normal">{{ __('Some information here') }}   </h4>
                    </div>
                </div>
            </div>
        </div>
@elseif(Session::get('currentpage')=='placeorder')
<!-- Page Title -->
        <div class="page-title bg-light">
            <div class="bg-image bg-parallax"><img src="{{ asset('images/placeorder.jpg') }}" alt=""></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-4">
                        <h1 class="mb-0 text-white font-weight-normal">{{ __('Place order') }}  </h1>
                        <h4 class="text-muted mb-0 font-weight-normal">{{ __('Some information here') }}  </h4>
                    </div>
                </div>
            </div>
        </div>
@endif

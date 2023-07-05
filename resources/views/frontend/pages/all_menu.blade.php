<div class="page-content">
    <div class="container">
        @if ($categories)
        <div class="row no-gutters">
            <div class="col-md-3">
                <!-- Menu Navigation -->
                <nav id="menu-navigation" class="stick-to-content" data-local-scroll>
                    <ul class="nav nav-menu bg-dark dark">
                          @foreach($categories as $row)
                           <li><a href="#cat{{ $row->id }}">{{ $row->getTranslation('category_name', App::getLocale()) }}</a></li>
                          @endforeach
                    </ul>
                </nav>
            </div>
            <div class="col-md-9">
                @php
                   $locale =  App::getLocale();
                @endphp
                @foreach($categories as $row)
                  <div id="cat{{ $row->id }}" class="menu-category">
                    <div class="menu-category-title">
                        @if ($row->categoryimg ==null)
                          <img class="bg-image" src="{{ asset('images/classdefaultimage.WebP') }}">
                        @else
                          <img class="bg-image" src="{{ asset('storage/'.app()->make('storage').'cats/'.$row->categoryimg) }}">
                        @endif
                       <h2 class="title">{{ $row->getTranslation('category_name', $locale) }}</h2>
                    </div>
                    <div class="menu-category-content">
                        @php
                            $materials = $row->materials;
                        @endphp
                        @if(count($materials)>0)
                            @if(App::make('option')->getOPtionVal('activateimages')=='1')
                            <div class="row justify-content-center mt-2" >
                                @foreach ($materials as $mat)
                                <div class="ml-2 mr-2 menu-item menu-list-item card" style="width: 18rem; min-height:auto">
                                    @if ($mat->materialimg ==null)
                                      <img style="width:210px" class="myImg card-img-top" src="{{ asset('images/noimage.jpg') }}">
                                    @else
                                      <img style="width:210px" class="myImg card-img-top" src="{{ asset('storage/'.app()->make('storage').'mats/'.$mat->materialimg) }}">
                                    @endif
                                    <div class="card-body text-center " >
                                        <h6  class="mb-10 card-title">{{ $mat->getTranslation('material_name', $locale) }}</h6>
                                        <span class="mt-3 text-muted text-sm card-text">{{ $mat->getTranslation('material_description', $locale) }}</span>
                                        <div class="justify-content-center text-center card-text mt-3 pt-3 row ">
                                            <span class="p-0 mt-3 col"><span class="text-muted">{{ (App::make('option')->getOPtionVal('startsfrom') =='1') ? __('from') : '' }}</span>{{ App::make('option')->getOPtionVal('currencysymbol') }}<span data-product-base-price>{{ number_format($mat->first_unit->price) }}</span></span>
                                            <button style="display:none;"  class="col p-0 btn btn-outline-secondary btn-block " data-action="open-cart-modal" data-utid="{{ $mat->first_unit->id }}" data-id="{{ $mat->id }}"><span>{{ __('Add to cart') }}</span></button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                                @foreach ($materials as $mat)
                                    <div class="menu-item menu-list-item">
                                        <div class="row text-center align-items-center" >
                                            <div class="col-6 mb-sm-0 ">
                                                <h6  class="mb-0">{{ $mat->getTranslation('material_name', $locale) }}</h6>
                                                <span class="text-muted text-sm">{{ $mat->getTranslation('material_description', $locale) }}</span>
                                            </div>
                                            <div class="col-6 text-sm-right" >
                                                <span class="text-md mr-4"><span class="text-muted">{{ (App::make('option')->getOPtionVal('startsfrom') =='1') ? __('from') : '' }}</span>{{ App::make('option')->getOPtionVal('currencysymbol') }}<span data-product-base-price>{{ number_format($mat->first_unit->price) }}</span></span>
                                                <button style="display:none;" class="btn btn-outline-secondary btn-sm" data-action="open-cart-modal" data-utid="{{ $mat->first_unit->id }}" data-id="{{ $mat->id }}"><span>{{ __('Add to cart') }}</span></button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endif
                  </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
         <!-- The Modal -->
    <div id="myModal" class="modalProd">
            <!-- The Close Button -->
            <span id="myclose" class="closeModal">&times;</span>
            <!-- Modal Content (The Image) -->
            <img class="modalContent" id="img01">
    </div>
  </div>
</div>
<div class="go_back">
    <a href="index.php">
    <i class="ti ti-angle-left"></i>
    </a>
</div>

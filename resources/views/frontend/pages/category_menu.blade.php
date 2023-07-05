<section class="wrapper">
    <div class="container">
        <div class="row">
            @php
                $locale=App::getLocale();
            @endphp

            @if($categories==null)
               @include('frontend.pages.all_menu');
            @else
               @foreach($categories as $row)
                            <div class="col-sm-4">
                                    <a class="text-white" href="?page=menu_list&category={{ $row->id }}">
                                        @if($row->categoryimg!==null)
                                            <div class="card text-white card-has-bg click-col" style="background-image:url({{ asset('storage/'.app()->make('storage').'cats/'.$row->categoryimg) }})">
                                        @else
                                            <div class="card text-white card-has-bg click-col" style="background-image:url({{ asset('images/classdefaultimage.WebP') }})">
                                        @endif

                                                <div class="card-img-overlay d-flex flex-column">
                                                    <div class="card-body">
                                                            <small class="card-meta mb-2">{{ $row->getTranslation('category_name', $locale) }}</small>
                                                            <h4 class="card-title mt-0">{{ $row->getTranslation('category_description', $locale) }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                    </a>
                            </div>
                    @endforeach
            @endif
     </div>
  </div>
</section>

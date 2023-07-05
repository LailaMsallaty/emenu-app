<x-frontend>
    
    @if (App::make('option')->getOPtionVal('activatemenu') =='1' || Session::get('currentpage') =='menu_list')
        @include('frontend.pages.all_menu')
    @else
        @include('frontend.pages.category_menu')
    @endif

</x-frontend>

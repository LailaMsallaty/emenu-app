<x-frontend>

<section id="confirmation" class="section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-4">
                <span class="icon icon-xl icon-success"><i class="ti ti-check-box"></i></span>
                <h1 class="mb-2">{{ Session::get('lastmsg1') }}</h1>
                <h4 class="text-muted mb-5">{{ Session::get('lastmsg2') }}</h4>
                <a href="{{ route('app.index') }}" class="btn btn-outline-secondary"><span>{{ __('Go back to the menu')}}</span></a>
            </div>
        </div>
    </div>
</section>
@php
  Session::flush();
@endphp
</x-frontend>

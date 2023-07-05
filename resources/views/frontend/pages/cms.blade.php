<x-frontend>
<article class="post single">
    <div class="post-image bg-parallax" style="background-position: bottom;"><img src="{{ asset('images/cms.jpg') }}" alt=""></div>
              <div class="container container-md">
                <div class="post-content">
                    <ul class="post-meta">
                        <li>{{ $page_obj->updated_at->format('d M ,Y') }}</li>
                    </ul>
                    <h1 class="post-title">{{ $page_obj->gettranslation('page_title',App::getLocale()) }}</h1>
                    @php
                        echo $page_obj->gettranslation('page_content',App::getLocale());
                    @endphp
                </div>
            </div>
        </div>
  </article>
</x-frontend>

<x-backend>
    <x-alert :errors="$errors" ></x-alert>

    <div class="col-md-12 mt-3">
        <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ __('Edit Page') }}</h3>
        </div>

        <form action="{{ Route('pages.update',['page'=>$page->id]) }}" method="post" enctype="multipart/form-data" id="idForm">
            @csrf
            @method('put')
            <div class="row">
                <div class="card-body">
                    <select id="langSelect" class="form-select langSelect" >
                        @foreach (App::make('languages') as $key => $lang)
                            <option value="{{ $key }}">
                               {{ $lang }}
                            </option>
                        @endforeach
                    </select>
                    <br>
                    <div>
                        @foreach (App::make('languages') as $key => $lang)
                           <div class="col langforms" data-id="{{ $key }}">
                              <br>
                                <div class="form-group mt-3 col-md-12">
                                    <label>{{  __('Page Title') }} - {{ $key }}   <span class="text-danger">*</span></label>
                                    <input required type="text" name="page_title[{{ $key }}]" class="form-control" value="{{ $page->gettranslation('page_title',$key) }}">
                                </div>

                                <div class="form-group col-md-12">
                                    <label>{{  __('Page Content') }} - {{ $key }}  <span class="text-danger">*</span></label>
                                    <textarea required name="content[{{$key}}]"  class="summernote form-control" >{{ $page->gettranslation('page_content',$key) }}</textarea>
                                </div>

                            </div>
                        @endforeach
                    </div>
                   <div class="card-footer">
                    <input type="hidden" name="id" value="{{ $page->id }}" class="form-control">
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                  </div>
                </div>
            </div>
        </form>
        </div>
    </div>

</x-backend>

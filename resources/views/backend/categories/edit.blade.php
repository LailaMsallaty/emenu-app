<x-backend>

    <x-alert :errors="$errors" ></x-alert>

    <div class="col-md-12 mt-3">
        <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ __('Edit Main Category') }}</h3>
        </div>

        <form action="{{ Route('category.update',$category->id) }}" method="post" enctype="multipart/form-data" id="idForm">
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
                    @foreach (App::make('languages') as $key => $lang)
                        <div data-id="{{ $key }}" class="langforms">
                                <br>
                                <div class="form-group mt-3 col-md-12">
                                    <label>{{  __('Category Name') }} - {{ $key }}   <span class="text-danger">*</span></label>
                                    <input type="text" name="category_name[{{ $key }}]" value="{{ $category->gettranslation('category_name',$key) }}" class="form-control">
                                </div>

                                <div class="form-group col-md-12">
                                    <label>{{  __('Category Description') }} - {{ $key }}</label>
                                    <textarea name="description[{{$key}}]" class="form-control" cols="10" rows="2">{{ $category->gettranslation('category_description',$key) }}</textarea>
                                </div>
                        </div>
                    @endforeach
                    <div class="form-group col-md-12">
                        <label for="categoryimg">{{  __('Category Image')}}</label>
                        <div class="custom-file" >
                            <input type="file" id="idupload"class="custom-file-input" name="categoryimg" value="{{ $category->categoryimg }}">
                            <label class="custom-file-label" for="categoryimg"></label>
                            <div class="update_img_div">
                                @if ($category->categoryimg==null)
                                  <img  id ="imagepreview" style="width:50px;height:50px" src="{{ asset('images/noimage.jpg') }}">
                                @else
                                  <img  id ="imagepreview" style="width:50px;height:50px" src="{{ asset('storage/'.app()->make('storage').'cats/'.$category->categoryimg) }}">
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($type=='')
                        <div class="form-group col-md-12">
                            <label for="categoryparent">{{  __('Category Parent')}}  <span class="text-danger">*</span></label>
                            <select class="custom-select" name="categoryparent" required>
                                @foreach ($categories as $parent)
                                    <option  value="{{ $parent->id }}"
                                      @if($parent->id == $category->category_father_id)
                                        selected
                                      @endif
                                    >{{ $parent->getTranslation('category_name', App::getLocale()); }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="form-group col-md-12">
                        <label for="categorytemplate">{{  __('Modifier Template')}}</label>
                        <select class="custom-select" name="modifiertemplate_id">
                            <option value=""></option>
                            @foreach ($templates as $template)
                                <option  value="{{ $template->id }}"
                                  @if($template->id == $category->modifiertemplate_id)
                                    selected
                                  @endif
                                >{{ $template->modifiertemplate_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                   <div class="card-footer">
                    <input type="hidden" name="type" value="{{ ($type=='') ? '':'main' }}">
                    <input type="hidden" value="{{ $category->id }}" name="id" class="form-control">
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                  </div>
                </div>
            </div>
        </form>
        </div>
    </div>

</x-backend>

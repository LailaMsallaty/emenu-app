<x-backend>

    <x-alert :errors="$errors" ></x-alert>

    <div class="col-md-12 mt-3">
        <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ __('Add Material') }}</h3>
        </div>

        <form action="{{ Route('material.store') }}" method="post" enctype="multipart/form-data" id="idForm">
            @csrf
            @method('post')
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
                                <div class="form-group mt-3 col-md-12">
                                    <label>{{  __('Material Name') }} - {{ $key }}   <span class="text-danger">*</span></label>
                                    <input required type="text" name="material_name[{{ $key }}]" class="form-control">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>{{  __('Material Description') }} - {{ $key }}</label>
                                    <textarea name="description[{{$key}}]" class="form-control" cols="10" rows="2"></textarea>
                                </div>
                            </div>
                        @endforeach
                        <div class="repeater form-group col-md-12">
                            <div data-repeater-list="List_units">
                                <div  data-repeater-item>
                                    <div class="row">
                                        @foreach (App::make('languages') as $key => $lang)
                                        <div class="col langforms" data-id="{{ $key }}">
                                            <label for="Name_{{ $key }}"
                                                    class="">{{ __('Unit Name') }} - {{ $key }}
                                                    : <span class="text-danger">*</span></label>
                                                <input  class="form-control" type="text" name="material_unit_name[{{$key}}]" />
                                        </div>
                                        @endforeach
                                        <div class="col">
                                            <label>{{  __('Unit Price') }}
                                                : <span class="text-danger">*</span></label>
                                            <input required type="number" name="price" class="form-control">
                                        </div>
                                        <div class="col mt-9 ">
                                            <input class="btn deleteRow btn-outline-danger btn-sm" data-repeater-delete
                                                type="button" value="{{ __('delete row') }}" />
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <div class="mt-35">
                                <div class="add_record" >
                                    <input class="btn btn-dark btn-sm" data-repeater-create type="button" value="{{ __('Add Unit') }}"/>
                                </div>
                             </div>
                        </div>
                        <br>
                       <div class="form-group col-md-12">
                        <label for="materialimg">{{  __('Material Image')}}</label>
                        <div class="custom-file " >
                            <input type="file" class="custom-file-input" name="materialimg" id="idupload">
                            <label class="custom-file-label" for="materialimg"></label>
                            <div class='item-box live-preview' style="width:50px;height:50px" >
                                <img style="width:50px;height:50px"  src='{{ URL:: asset('images/noimage.jpg') }}' id ="imagepreview" alt="Image Preview" />
                           </div>
                        </div>
                      </div>
                        <div class="form-group col-md-12">
                            <label for="categoryparent">{{  __('Category')}}  <span class="text-danger">*</span></label>
                            <select class="custom-select" name="categoryparent" required >
                                @foreach ($categories as $category)
                                    <option  value="{{ $category->id }}">{{ $category->getTranslation('category_name', App::getLocale()); }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="categorytemplate">{{  __('Modifier Template')}}</label>
                            <select class="custom-select" name="modifiertemplate_id">
                                <option value=""></option>
                                @foreach ($templates as $template)
                                    <option  value="{{ $template->id }}">{{ $template->modifiertemplate_name }}</option>
                                @endforeach
                            </select>
                        </div>
                   <div class="card-footer">
                    <input type="hidden" name="id" class="form-control">
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                  </div>
                </div>
            </div>
        </form>
        </div>
    </div>

</x-backend>

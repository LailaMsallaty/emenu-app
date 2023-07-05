<x-backend>

    <x-alert :errors="$errors" ></x-alert>

    <div class="col-md-12 mt-3">
        <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ __('Edit Modifier') }}</h3>
        </div>

        <form action="{{ Route('modifiers.update',['modifier'=> $modifier->id]) }}" method="post" id="idForm">
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
                    <div class="col langforms" data-id="{{ $key }}">
                        <br>
                            <div class="form-group mt-3">
                                <label>{{  __('Modifier Name') }} - {{ $key }}   <span class="text-danger">*</span></label>
                                <input type="text" name="modifier_name[{{ $key }}]" value="{{ $modifier->gettranslation('modifier_name',$key) }}" class="form-control">
                            </div>
                    </div>
                    @endforeach
                    <div class="form-group col-md-12">
                        <label for="template_id">{{  __('Modifier Template')}}  <span class="text-danger">*</span></label>
                        <select required class="custom-select" name="template_id">
                            @foreach ($templates as $template)
                                <option  value="{{ $template->id }}"
                                    @if($template->id == $modifier->modifiertemplate_id)
                                      selected
                                    @endif
                                >{{ $template->modifiertemplate_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label>{{  __('Unit Price') }}
                            : <span class="text-danger">*</span></label>
                        <input required type="number" value="{{ $modifier->modifier_price }}" name="price" class="form-control">
                    </div>
                   <div class="card-footer">
                    <input type="hidden" name="id" value="{{ $modifier->id }}" class="form-control">
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                  </div>
                </div>
            </div>
        </form>
        </div>
    </div>

</x-backend>

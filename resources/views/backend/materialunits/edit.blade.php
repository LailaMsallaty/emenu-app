<x-backend>

    <x-alert :errors="$errors" ></x-alert>

    <div class="col-md-12 mt-3">
        <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ __('Edit Unit') }}</h3>
        </div>

        <form action="{{ Route('materialunit.update',['materialunit'=> $unit->id]) }}" method="post" id="idForm">
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
                                <label>{{  __('Material Unit Name') }} - {{ $key }}   <span class="text-danger">*</span></label>
                                <input type="text" name="material_unit_name[{{ $key }}]" value="{{ $unit->gettranslation('material_unit_name',$key) }}" class="form-control">
                            </div>
                    </div>
                    @endforeach
                    <div class="form-group col-md-12">
                        <label for="material">{{  __('Material')}}</label>
                        <select class="custom-select" name="material_id">
                            @foreach ($materials as $material)
                                <option  value="{{ $material->id }}"
                                    @if($material->id == $unit->material_id)
                                      selected
                                    @endif
                                >{{ $material->getTranslation('material_name', App::getLocale()); }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label>{{  __('Unit Price') }}
                            : <span class="text-danger">*</span></label>
                        <input required type="number" value="{{ $unit->price }}" name="price" class="form-control">
                    </div>
                   <div class="card-footer">
                    <input type="hidden" name="id" value="{{ $unit->id }}" class="form-control">
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                  </div>
                </div>
            </div>
        </form>
        </div>
    </div>

</x-backend>

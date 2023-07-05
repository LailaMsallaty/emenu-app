<x-backend>

    <x-alert :errors="$errors" ></x-alert>

    <div class="col-md-12 mt-3">
        <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ __('Add Units') }}</h3>
        </div>

        <form action="{{ Route('materialunit.store') }}" method="post"  id="idForm">
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
                        <div class="repeater form-group col-10">
                                <div data-repeater-list="List_units">
                                    <div data-repeater-item>
                                        <div class="row">
                                            @foreach (App::make('languages') as $key => $lang)
                                            <div class="col langforms" data-id="{{ $key }}">
                                                <label for="Name_{{ $key }}">{{ __('Unit Name') }} - {{ $key }}
                                                        : <span class="text-danger">*</span></label>
                                                <input  class="form-control" type="text" name="material_unit_name[{{$key}}]" />
                                            </div>
                                            @endforeach
                                            <div class="col">
                                                <label>{{  __('Unit Price') }}
                                                    : <span class="text-danger">*</span></label>
                                                <input required type="number" name="price" class="form-control">
                                            </div>
                                            <div class="col mt-9">
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
                   <div class="card-footer">
                    <input type="hidden" name="material_id" value="{{ $material->id }}" class="form-control">
                    <input type="hidden" name="id" class="form-control">
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                  </div>
                </div>
            </div>
        </form>
        </div>
    </div>

</x-backend>

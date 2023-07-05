
    <div class="col-md-12 mt-3">
        <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ __('Add Languages') }}</h3>
        </div>

        <form action="{{ Route('languages.store') }}" method="post"  id="idForm">
            @csrf
            @method('post')
            <div class="row">
                <div class="card-body">
                    <br>
                        <div class="repeater form-group col-10">
                                <div data-repeater-list="List_langs">
                                    <div data-repeater-item>
                                        <div class="row">
                                            <div class="col langforms">
                                                <label for="Code">{{ __('Lang Code') }}
                                                        : <span class="text-danger">*</span></label>
                                                <input  class="form-control" type="text" name="lang_code" />
                                            </div>
                                            <div class="col langforms">
                                                <label for="Name">{{ __('Lang Name') }}
                                                        : <span class="text-danger">*</span></label>
                                                <input  class="form-control" type="text" name="lang_name" />
                                            </div>
                                            <div class="col langforms">
                                                <label for="Name">{{ __('Is RTL') }}
                                                        : <span class="text-danger">*</span></label>
                                                <input class="form-control" style="width: 40px;" type="checkbox" name="is_rtl" />
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
                                        <input class="btn btn-dark btn-sm" data-repeater-create type="button" value="{{ __('Add Language') }}"/>
                                    </div>
                                </div>
                            </div>
                     <br>
                   <div class="card-footer">
                    <input type="hidden" name="lang_id" value="{{ $lang->id }}" class="form-control">
                    <input type="hidden" name="id" class="form-control">
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                  </div>
                </div>
            </div>
        </form>
        </div>
    </div>

<x-backend>
    <x-alert :errors="$errors" ></x-alert>

    <div class="col-md-12 mt-3">
        <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ __('Edit Unit') }}</h3>
        </div>

        <form action="{{ Route('language.update',['lang'=> $lang->id]) }}" method="post" id="idForm">
            @csrf
            @method('put')
            <div class="row">
                <div class="card-body">
                    <br>
                    <div class="col">
                        <br>
                        <div class="form-group mt-3">
                            <label>{{  __('Lang Code') }}  <span class="text-danger">*</span></label>
                            <input type="text" name="lang_code" value="{{ $lang->lang_code }}" class="form-control">
                        </div>
                        <div class="form-group mt-3">
                            <label>{{  __('Lang Name') }}  <span class="text-danger">*</span></label>
                            <input type="text" name="lang_name" value="{{ $lang->lang_name }}" class="form-control">
                        </div>
                        <div class="form-group mt-3">
                            <label>{{  __('Is RTL') }}  <span class="text-danger">*</span></label>
                            <input type="checkbox" name="is_rtl" @php if ($lang->isrtl==1) {
                                echo 'checked';
                            } @endphp class="form-control" style="width: 40px">
                        </div>

                    </div>
                   <div class="card-footer">
                    <input type="hidden" name="lang_id" value="{{ $lang->id }}" class="form-control">
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                  </div>
                </div>
            </div>
        </form>
        </div>
    </div>


</x-backend>

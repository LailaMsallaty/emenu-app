<x-backend>
    <x-alert :errors="$errors" ></x-alert>

    <div class="col-md-12 mt-3">
        <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ __('Add Modifier Templates') }}</h3>
        </div>

        <form action="{{ Route('modifiertemplates.update',['modifiertemplate'=>$template]) }}" method="post"  id="idForm">
            @csrf
            @method('put')
            <div class="row">
                <div class="card-body">
                    <div class="col-6">
                        <label for="templateName"
                            class="">{{ __('Template Name') }}
                            : <span class="text-danger">*</span></label>
                        <input required value="{{ $template->modifiertemplate_name }}" id="templateName" class="form-control" type="text" name="templateName" />
                    </div>
                    <br>
                   <div class="card-footer">
                    <input type="hidden" name="id" value="{{ $template->id }}" class="form-control">
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                  </div>
                </div>
            </div>
        </form>
        </div>
    </div>

</x-backend>

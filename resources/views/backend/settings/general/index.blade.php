<x-backend>

    <x-alert :errors="$errors" ></x-alert>

    <div class="col-md-6">

    @include("backend.settings.general.site")
    @include("backend.settings.general.delivery")
    @include("backend.settings.general.menu")

    </div>
    <div class="col-md-6">

    @include("backend.settings.general.order")
    @include("backend.settings.general.location")

    </div>
</x-backend>

<div class="card card-primary">
    <div class="card-header">
    <h3 class="card-title">Location Settings</h3>
    </div>
    <form method="POSt"  action="{{ route('settings.store') }}">
        @csrf
        @method('post')
        <div class="card-body">
            <div class="form-group">
                <label for="activatelocation">Activate Location</label>
                <input type="checkbox" name="activatelocation"
                value="{{ ($option->getOptionVal("activatelocation")=="1")?"1":"0"  }}"
                {{ ($option->getOptionVal("activatelocation")=="1")?"checked":"" }}
                 data-bootstrap-switch="" >
            </div>
            <div class="form-group">
                <label for="lat">Latitude</label>
                <input required type="text" name="latitude" class="form-control" placeholder="Latitude"
                value="{{ $option->getOptionVal("latitude") }}">
            </div>
            <div class="form-group">
                <label for="longitude">longitude</label>
                <input required type="text" name="longitude" class="form-control" placeholder="Longitude"
                value="{{ $option->getOptionVal("longitude") }}">
            </div>
            <div class="form-group">
                <label for="activatenotification">Activate Notification</label>
                <input type="checkbox" name="activatenotification"
                value="{{ ($option->getOptionVal("activatenotification")=="1")?"1":"0"  }}"
                {{ ($option->getOptionVal("activatenotification")=="1")?"checked":""  }}
                  data-bootstrap-switch="">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" name="locationsettingsbtn" value="1" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>

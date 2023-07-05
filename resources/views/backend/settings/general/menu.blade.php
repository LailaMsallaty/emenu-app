<div class="card card-primary">
    <div class="card-header">
    <h3 class="card-title">Menu Settings</h3>
    </div>
    <form method="POST"  action="{{ route('settings.store') }}">
        @csrf
        @method('post')
        <div class="card-body">
            <div class="form-group">
                <label for="activatemenu">Activate All Menu</label>
                <input type="checkbox" name="activatemenu"
                value="{{ ($option->getOptionVal("activatemenu")=="1")?"1":"0"  }}"
                {{ ($option->getOptionVal("activatemenu")=="1")?"checked":"" }}
                data-bootstrap-switch="">
            </div>
            <div class="form-group">
                <label for="activateimages">Activate Material Images</label>
                <input type="checkbox" name="activateimages"
                value="{{ ($option->getOptionVal("activateimages")=="1")?"1":"0"  }}"
                {{ ($option->getOptionVal("activateimages")=="1")?"checked":"" }}
                data-bootstrap-switch="">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" name="menusettingbtn" value="1" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>

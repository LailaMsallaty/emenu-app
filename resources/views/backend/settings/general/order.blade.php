<div class="card card-primary">
    <div class="card-header">
    <h3 class="card-title">Order Settings</h3>
    </div>
    <form method="POST"  action="{{ route('settings.store') }}">
        @csrf
        @method('post')
        <div class="card-body">
            <div class="form-group">
                <label for="activateorder">Activate Order</label>
                <input type="checkbox" name="activateorder"
                value="{{ ($option->getOptionVal("activateorder")=="1")?"1":"0"  }}"
                {{ ($option->getOptionVal("activateorder")=="1")?"checked":"" }}
                data-bootstrap-switch="">
            </div>
            <div class="form-group">
                <label for="activatetables">Activate Tables</label>
                <input type="checkbox" name="activatetables"
                {{ ($option->getOptionVal("activatetables")=="1")?"checked":"" }}
                data-bootstrap-switch="">
            </div>
            <div class="form-group">
                <label for="enforcetablespreselection">Enforce Tables Preselection</label>
                <input type="checkbox" name="enforcetablespreselection"
                 data-test=""
                 {{ ($option->getOptionVal("enforcetablespreselection")=="1")?"checked":"" }}
                 data-bootstrap-switch="">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" name="ordersttingbtn" value="1" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>

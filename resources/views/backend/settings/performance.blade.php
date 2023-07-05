<x-backend>
    <x-alert :errors="$errors" ></x-alert>

  <div class="col-xl-10 col-lg-10">
	<div class="card card-primary">
            <div class="card-header">
               <h3 class="card-title">Maintenance Options</h3>
            </div>
            <form method="post" action="{{ route('performance.clearCache') }}" style="margin:50px 20px 0px 0px">
                @csrf
                @method('post')
                <div class="form-group add_record">
                        <input type="submit" value="Clear Cache" name="clear_cache" class="btn btn-primary ml-4" >
                </div>
            </form>
            <form method="post" action="{{ route('performance.store') }}" class="maintenanceoptionsform">
                @csrf
                @method('post')
                <div class="card-body col-6">
                    <div class="form-group ">
                        <label for="maintenancemode">Activate Maintenance Mode</label>
                        <input type="checkbox" name="maintenancemode"
                        value="{{ ($option->getOptionVal("maintenancemode")=="1")?"1":"0"  }}"
                        {{ ($option->getOptionVal("maintenancemode")=="1")?"checked":"" }}
                        data-bootstrap-switch="" >
                    </div>
                    <div class="form-group ">
                        <label for="ip_address">Secret Token</label>
                        <input disabled type="text" name="ip_address" value="{{ config()->get('app.maintanance_token') }}"  class="form-control">
                        <br>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" name="performance_btn" value="1">Save</button>
                </div>
            </form>
	</div>
</div>
</x-backend>

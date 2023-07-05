<x-backend>
    <x-alert :errors="$errors" ></x-alert>

<div class="col-xl-10 col-lg-10">
	<div class="card card-primary">
            <div class="card-header">
            <h3 class="card-title">Generating Tables</h3>
            </div>
            <!-- form start -->
            <form method="post" action="{{ route('generateTables.store') }}" class="maintenanceoptionsform">
             @csrf
             @method('post')
            <div class="card-body">
                <div class="form-group">
                    <div class="float-md-left">
                        <label>Table Numbers</label><br>
                        <textarea class="form-control" rows="8" name="tblcodes" id="tblcodes">@php
                            if($option->getOptionVal('tblcodes') !=='')
                             {
                               $new_array = array_values(array_filter(explode(",",$option->getOptionVal('tblcodes'))));
                               foreach($new_array as $value){ echo $value."\n"; }
                             }@endphp</textarea>
                    </div>
                    <div style="position: absolute;left: 30%;top: 45%;">
                        <input type="button" class="btn btn-primary" value="Generat" id="generatecode">
                    </div>
                    <div class="float-xl-right">
                        <label>Table Codes</label><br>
                        <textarea class="form-control" disabled rows="8" name="tblurls" id="tblurls" style="min-width: 450px;"></textarea>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" name="generating_tables_btn">Save</button>
            </div>
        </form>
	</div>
</div>
</x-backend>

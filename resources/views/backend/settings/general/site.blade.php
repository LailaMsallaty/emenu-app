<div class="card card-primary">
    <div class="card-header">
    <h3 class="card-title">Site Settings</h3>
    </div>
    <form method="POST"  action="{{ route('settings.store') }}">
        @csrf
        @method('post')
        <div class="card-body">
            <div class="form-group">
                <label for="sitename">Site Name</label>
                <input required type="text"  name="sitename" class="form-control" id="sitename" placeholder="Enter Site Name"
                value="{{ $option->getOptionVal('sitename') }}">
            </div>
            <div class="form-group">
                <label for="currencysymbol">Currency Symbol</label>
                <input required type="text"  name="currencysymbol" class="form-control" id="currencysymbol" placeholder="Surrency Symbol"
                value="{{ $option->getOptionVal('currencysymbol') }}">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>

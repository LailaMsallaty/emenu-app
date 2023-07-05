<div class="card card-primary">
    <div class="card-header">
    <h3 class="card-title">Delivery Settings</h3>
    </div>
    <form method="POST"  action="{{ route('settings.store') }}">
        @csrf
        @method('post')
        <div class="card-body">
            <div class="form-group">
                <label for="activatedelivery">Activate Delivery</label>
                <input type="checkbox" name="activatedelivery"
                value="{{ ($option->getOptionVal("activatedelivery")=="1")?"1":"0"  }}"
                {{ ($option->getOptionVal("activatedelivery")=="1")?"checked":"" }}
                data-bootstrap-switch="">
            </div>
            <div class="form-group">
                <label for="deliveryPrice">Delivery Price</label>
                <input required type="text" name="deliveryPrice" class="form-control" placeholder="Delivery Price"
                value="{{ $option->getOptionVal('deliveryPrice') }}">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" name="deliverysettingbtn" value="1" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>

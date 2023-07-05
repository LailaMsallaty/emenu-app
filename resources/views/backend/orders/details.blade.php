<x-backend>
    <div class="col-12 " >
        <div class="card" >
            <div class="card-header">
                <h3 class="card-title">Orders</h3>
            </div>
            <div class="card-body" >
                <input type='submit'  id='delButton' data-url=" {{ route("delete_orders_group") }}" disabled value='Delete' name='but_delete'  class=" delButton mr-2 btn btn-outline-danger btn-sm">
                <table  id="example2" class="table table-bordered table-hover ">
                    <thead>
                        <tr>
                            <th>Order Reference</th>
                            <th>Id</th>
                            <th>CategoryId</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Ingredients</th>
                            <th>Total Price</th>
                            <th>Note</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                <tbody class="row_position" >

                  @foreach ($order_details as $row)
                    <tr id="{{ $row->id }}">
                      <td>{{ $row->_ref }}</td>
                      <td>{{ $row->id }}</td>
                      <td>{{ $row->categoryId }}</td>
                      <td>{{ $row->name }}</td>
                      <td>{{ $row->price }}</td>
                      <td>{{ $row->ingredients[0] }}</td>
                      <td>{{ $row->totalPrice }}</td>
                      <td>{{ $row->note }}</td>
                      <td>{{ $row->quantity }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Order Reference</th>
						<th>Id</th>
						<th>CategoryId</th>
						<th>Name</th>
						<th>Price</th>
						<th>Ingredients</th>
						<th>Total Price</th>
						<th>Note</th>
						<th>Quantity</th>
                    </tr>
                </tfoot>
                </table>
            </div>
        </div>
    </div>
    </x-backend>

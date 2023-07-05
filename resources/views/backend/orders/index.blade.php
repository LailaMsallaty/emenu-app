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
                            <th class="text-center info"><input type="checkbox" name="checkAll" class="checkAll"></th>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Table Code</th>
                            <th>Order Total</th>
                            <th>Is Posted</th>
                            <th>Post Date</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                <tbody class="row_position" >
                        @php
                            $locale = App::getLocale();
                            $i=1;
                        @endphp
                   @foreach($orders as $row)
                        <tr>
                            <td class="text-center"><input type="checkbox" name="delete[]" class="checkboxes" value="{{ $row->id }}" ></td>
                            <td>{{ $i }}</td>
                            <td>{{ $row->order_date }}</td>
                            <td>{{ $row->client_name }}</td>
                            <td>{{ $row->client_email }}</td>
                            <td>{{ $row->tablecode }}</td>
                            <td>{{ $row->ordertotal }}</td>
                            <td class="text-center">@if($row->isposted==1)
                                <i class="fas fa-check text-success"></i>
                                @else
                                <i class="fas fa-times-circle text-danger"></i>
                                @endif
                            </td>
                            <td>{{ $row->posteddate }}</td>

                             <td>
                                <a target="_self" href="{{ route('orders.show',['order'=>$row->id]) }}" class="btn btn-block btn-outline-success btn-xs" >Details</a>
                            </td>
                        </tr>
                        @php
                          $i++;
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center info"><input type="checkbox" name="checkAll" class="checkAll"></th>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Table Code</th>
                        <th>Order Total</th>
                        <th>Is Posted</th>
                        <th>Post Date</th>
                        <th>Details</th>
                    </tr>
                </tfoot>
                </table>
            </div>
        </div>
    </div>
    </x-backend>

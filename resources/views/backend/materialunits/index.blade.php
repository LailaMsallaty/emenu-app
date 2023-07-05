<x-backend>
    <div class="col-12 " >
        <div class="card" >
            <div class="card-header">
                <h3 class="card-title">Material Units Food</h3>
            </div>
            <div class="card-body" >
                <input type='submit'  id='delButton' data-url="{{ route("delete_units_group") }}" disabled value='Delete' name='but_delete'  class=" delButton mr-2 btn btn-outline-danger btn-sm">
                <table  id="example2" class="table table-bordered table-hover ">
                    <thead>
                        <tr>
                            <th class="text-center info"><input type="checkbox" name="checkAll" class="checkAll"></th>
                            <th>Material Name</th>
                            <th>Unit Name</th>
                            <th>Price</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                <tbody class="row_position" >
                        @php
                            $locale = App::getLocale();
                        @endphp
                   @foreach($units as $row)
                        <tr>
                            <td class="text-center"><input type="checkbox" name="delete[]" class="checkboxes" value="{{ $row->id }}" ></td>
                            <td>{{ $row->material->getTranslation('material_name', $locale) }}</td>
                            <td>{{ $row->getTranslation('material_unit_name', $locale) }}</td>
                            <td>{{ $row->price }}</td>
                            <td>
                                <a target="_self" href="{{ route('materialunit.edit',['materialunit'=>$row->id]) }}" class="btn btn-block btn-outline-success btn-xs" >Edit</a>
                            </td>
                            <td>
                                <input type="hidden" name="parent_id" value="{{ $row->material->id }}">
                                <button  data-id="{{ $row->id }}" data-url="{{ route('materialunit.destroy', ['materialunit'=>$row->id]) }}" class="deleteRecord btn btn-block btn-outline-danger btn-xs" >Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center info"><input type="checkbox" name="checkAll" class="checkAll"></th>
                        <th>Material Name</th>
                        <th>Unit Name</th>
                        <th>Price</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                </table>
            </div>
        </div>
    </div>
    </x-backend>

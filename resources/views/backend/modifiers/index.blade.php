<x-backend>
    <div class="col-12 " >
        <div class="card" >
            <div class="card-header">
                <h3 class="card-title">Modifiers</h3>
            </div>
            <div class="card-body" >
                <input type='submit'  id='delButton' data-url=" {{ route("delete_modifiers_group") }}" disabled value='Delete' name='but_delete'  class=" delButton mr-2 btn btn-outline-danger btn-sm">
                <table  id="example2" class="table table-bordered table-hover ">
                    <thead>
                        <tr>
                            <th class="text-center info"><input type="checkbox" name="checkAll" class="checkAll"></th>
                            <th>Template</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                <tbody class="row_position" >
                        @php
                            $locale = App::getLocale();
                        @endphp
                   @foreach($modifiers as $row)
                        <tr>
                            <td class="text-center"><input type="checkbox" name="delete[]" class="checkboxes" value="{{ $row->id }}" ></td>
                            <td>{{ $row->modifierTemplate->modifiertemplate_name }}</td>
                            <td>{{ $row->getTranslation('modifier_name', $locale) }}</td>
                            <td>{{ $row->modifier_price }}</td>
                             <td>
                                <a target="_self" href="{{ route('modifiers.edit',['modifier'=>$row->id]) }}" class="btn btn-block btn-outline-success btn-xs" >Edit</a>
                            </td>
                            <td>
                                <input type="hidden" name="parent_id" value="{{ $row->modifierTemplate->id }}">
                                <button  data-id="{{ $row->id }}" data-url="{{ route('modifiers.destroy',['modifier'=>$row->id])}}" class="deleteRecord btn btn-block btn-outline-danger btn-xs" >Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                           <th class="text-center info"><input type="checkbox" name="checkAll" class="checkAll"></th>
                           <th>Template</th>
                            <th>Name</th>
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

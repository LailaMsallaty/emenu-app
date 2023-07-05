<x-backend>
    <div class="col-12 " >
        <div class="card" >
            <div class="card-header">
                <h3 class="card-title">Modifier Template</h3>
            </div>
            <div class="card-body" >
                <input type='submit'  id='delButton' data-url=" {{ route("delete_templates_group") }}" disabled value='Delete' name='but_delete'  class=" delButton mr-2 btn btn-outline-danger btn-sm">
                <table  id="example2" class="table table-bordered table-hover ">
                    <thead>
                        <tr>
                            <th class="text-center info"><input type="checkbox" name="checkAll" class="checkAll"></th>
                            <th>Name</th>
                            <th>Details</th>
                            <th>Add Modifiers</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                <tbody class="row_position" >
                        @php
                            $locale = App::getLocale();
                        @endphp
                   @foreach($templates as $row)
                        <tr>
                            <td class="text-center"><input type="checkbox" name="delete[]" class="checkboxes" value="{{ $row->id }}" ></td>
                            <td>{{ $row->modifiertemplate_name }}</td>
                            <td>
                                <a target="_self" href="{{ route('modifiertemplate.modifiers',['modifiertemplate'=>$row->id]) }}" class="btn btn-block btn-outline-warning btn-xs" >Details</a>
                            </td>
                            <td>
                                <a target="_self" href="{{ route('createModifiers',['modifiertemplate'=>$row->id]) }}"  class="btn btn-block btn-outline-primary btn-xs" >Add Modifiers</a>
                             </td>
                             <td>
                                <a target="_self" href="{{ route('modifiertemplates.edit',['modifiertemplate'=>$row->id]) }}" class="btn btn-block btn-outline-success btn-xs" >Edit</a>
                            </td>
                            <td>
                                <button  data-id="{{ $row->id }}" data-url="{{ route('modifiertemplates.destroy',['modifiertemplate'=>$row->id])}}" class="deleteRecord btn btn-block btn-outline-danger btn-xs" >Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                           <th class="text-center info"><input type="checkbox" name="checkAll" class="checkAll"></th>
                           <th>Modifier Template</th>
                           <th>Details</th>
                           <th>Add Modifiers</th>
                           <th>Update</th>
                           <th>Delete</th>
                    </tr>
                </tfoot>
                </table>
            </div>
        </div>
    </div>
    </x-backend>

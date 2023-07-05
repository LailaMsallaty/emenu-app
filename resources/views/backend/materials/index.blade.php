<x-backend>
    <div class="col-12 " >
        <div class="card" >
            <div class="card-header">
                <h3 class="card-title">Material Food</h3>
            </div>
            <div class="card-body" >
                <input type='submit'  id='delButton' data-url=" {{ route("delete_mats_group") }}" disabled value='Delete' name='but_delete'  class=" delButton mr-2 btn btn-outline-danger btn-sm">
                <table  id="example2" class="table table-bordered table-hover ">
                    <thead>
                        <tr>
                            <th class="text-center info"><input type="checkbox" name="checkAll" class="checkAll"></th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Modifier Template</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Add Units</th>
                            <th>Units</th>
                            <th>Update</th>
                            <th>Delete</th>


                        </tr>
                    </thead>
                <tbody class="row_position" >
                        @php
                            $locale = App::getLocale();
                        @endphp
                   @foreach($materials as $row)
                        <tr>
                            <td class="text-center"><input type="checkbox" name="delete[]" class="checkboxes" value="{{ $row->id }}" ></td>
                            <td>{{ $row->getTranslation('material_name', $locale) }}</td>
                            <td>{{ $row->getTranslation('material_description', $locale) }}</td>
                            <td>{{ $row->modifierTemplate->modifiertemplate_name }}</td>
                            <td>
                            @if ($row->materialimg =="")
                              <img style="width:50px;height:50px" src="{{ asset('images/noimage.jpg') }}">
                            @else
                              <img style="width:50px;height:50px" src="{{ asset('storage/'.app()->make('storage').'mats/'.$row->materialimg) }}">
                            @endif
                            </td>
                            <td>
                                {{ $row->category->category_name }}
                            </td>
                            <td>
                              <a target="_self" href="{{ route('createMaterialunit',['material'=>$row->id]) }}"  class="btn btn-block btn-outline-primary btn-xs" >Add Units</a>
                            </td>
                            <td>
                                <a target="_self" href="{{ route('material.units',['material'=>$row->id]) }}"  class="btn btn-block btn-outline-warning btn-xs" >Units</a>
                            </td>
                            <td>
                                <a target="_self" href="{{ route('material.edit',['material'=>$row->id]) }}" class="btn btn-block btn-outline-success btn-xs" >Edit</a>
                            </td>
                            <td>
                                <button  data-id="{{ $row->id }}" data-url="{{ route('material.destroy',['material'=>$row->id])}}" class="deleteRecord btn btn-block btn-outline-danger btn-xs" >Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                           <th class="text-center info"><input type="checkbox" name="checkAll" class="checkAll"></th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Modifier Template</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Add Units</th>
                            <th>Units</th>
                            <th>Update</th>
                            <th>Delete</th>
                    </tr>
                </tfoot>
                </table>
            </div>
        </div>
    </div>
    </x-backend>

<x-backend>
    @include('backend.settings.languages.create')
    <br>
    <div class="col-12 " >
        <div class="card" >
            <div class="card-header">
                <h3 class="card-title">Languages</h3>
            </div>
            <div class="card-body" >
                <input type='submit'  id='delButton' data-url="{{ route("delete_langs_group") }}" disabled value='Delete' name='but_delete'  class=" delButton mr-2 btn btn-outline-danger btn-sm">
                <table  id="example2" class="table table-bordered table-hover ">
                    <thead>
                        <tr>
                            <th class="text-center info"><input type="checkbox" name="checkAll" class="checkAll"></th>
                            <th>Language Code</th>
                            <th>Language Name</th>
                            <th>Is RTL</th>
                            <th>Update</th>

                        </tr>
                    </thead>
                <tbody class="row_position" >
                   @foreach($langs as $row)
                        <tr>
                            <td class="text-center"><input type="checkbox" name="delete[]" class="checkboxes" value="{{ $row->id }}" ></td>
                            <td>{{ $row->lang_code }}</td>
                            <td>{{ $row->lang_name }}</td>
                            <td>{{ ($row->isrtl==0)?'false':'true' }}</td>
                            <td>
                                <a target="_self" href="{{ route('language.edit',['lang'=>$row->id]) }}" class="btn btn-block btn-outline-success btn-xs" >Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center info"><input type="checkbox" name="checkAll" class="checkAll"></th>
                        <th>Language Code</th>
                        <th>Language Name</th>
                        <th>Is RTL</th>
                        <th>Update</th>
                    </tr>
                </tfoot>
                </table>
            </div>
        </div>
    </div>
    </x-backend>

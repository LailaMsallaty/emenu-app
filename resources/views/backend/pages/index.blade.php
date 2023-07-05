<x-backend>
    <div class="col-12 " >
        <div class="card" >
            <div class="card-header">
                <h3 class="card-title">Pages</h3>
            </div>
            <div class="card-body" >
              <input type='submit'  id='delButton' data-url=" {{ route("delete_pages_group") }}" disabled value='Delete' name='but_delete'  class=" delButton mr-2 btn btn-outline-danger btn-sm">
                <table  id="example2" class="table table-bordered table-hover ">
                    <thead>
                        <tr>
                            <th class="text-center info"><input type="checkbox" name="checkAll" class="checkAll"></th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Update</th>
                        </tr>
                    </thead>
                <tbody class="row_position" >
                        @php
                            $locale = App::getLocale();
                            $i=1;
                        @endphp
                   @foreach($pages as $row)
                        <tr>
                            <td class="text-center"><input type="checkbox" name="delete[]" class="checkboxes" value="{{ $row->id }}" ></td>
                            <td>{{ $i }}</td>
                            <td>{{ $row->getTranslation('page_title', $locale) }}</td>
                             <td>
                                <a target="_self" href="{{ route('pages.edit',['page'=>$row->id]) }}" class="btn btn-block btn-outline-success btn-xs" >Edit</a>
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
                           <th>Name</th>
                           <th>Update</th>
                    </tr>
                </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-backend>

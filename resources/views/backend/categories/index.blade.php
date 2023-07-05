<x-backend>
<div class="col-12 " >
	<div class="card" >
		<div class="card-header">
			<h3 class="card-title">Category Food</h3>
		</div>
		<div class="card-body" >
               <input type="submit" data-url="{{ route("delete_cats_group") }}"  id='delButton' disabled value='Delete' name='but_delete'  class=" delButton mr-2 btn btn-outline-danger btn-sm">
			<table  id="example2" class="table table-bordered table-hover ">
				<thead>
					<tr>
				    	<th class="text-center info"><input type="checkbox" name="checkAll" class="checkAll"></th>
						<th>Category Name</th>
						<th>Description</th>
                        @if($type=='')
                          <th>Category Parent</th>
                        @endif
                        <th>Modifier Template</th>
						<th>Image</th>
					    <th>Material</th>
						{{-- <th>Sort</th> --}}
						<th>Update</th>
						<th>Delete</th>

					</tr>
				</thead>
			<tbody class="row_position" >
					@php
						$count = count($categories);
                        $locale = App::getLocale();
                        $num = 0;
			    	@endphp
			   @foreach($categories as $row)
					<tr id="{{ $row->id }}">
                        <td class="text-center"><input type="checkbox" name="delete[]" class="checkboxes" value="{{ $row->id }}" ></td>
                        <td>{{ $row->getTranslation('category_name', $locale) }}</td>
                        <td>{{ $row->getTranslation('category_description', $locale) }}</td>
                        @if($type=='')
                         <td>{{ $row->parent->getTranslation('category_name', $locale) }}</td>
                        @endif
                        <td>{{ $row->modifierTemplate->modifiertemplate_name }}</td>
                        <td>
                        @if ($row->categoryimg =="")
                          <img style="width:50px;height:50px" src="{{ asset('images/noimage.jpg') }}">
                        @else
                          <img style="width:50px;height:50px" src="{{ asset('storage/'.app()->make('storage').'cats/'.$row->categoryimg) }}">
                        @endif
                        </td>
                        <td>
                           <a target="_self" href="{{ route('CategoryMaterials',['category'=>$row->id]) }}"
                                              class="btn btn-block btn-outline-warning btn-xs">{{__('Materials')}}</a>
                        </td>
                        {{-- <td>
                            @if($num == $count-1)
                            <button  data-id="{{ $row->id }}" class=" last-cat-item btn btn-link btn-sm arrow-down" name="arrow-down"><i class="fa fa-arrow-down"></i></button>
                            @else
                            <button  data-id="{{ $row->id }}"  class=" btn btn-link btn-sm arrow-down" name="arrow-down"><i class="fa fa-arrow-down"></i></button>

                            @endif

                            @if($num == 0)
                            <button data-id="{{ $row->categoryimg }}" class=" first-cat-item btn btn-link btn-sm arrow-up"  name="arrow-up"><i class="fa fa-arrow-up"></i></button>
                            @else
                            <button data-id="{{ $row->id }}"  class=" btn btn-link btn-sm arrow-up" name="arrow-up"><i class="fa fa-arrow-up"></i></button>
                            @endif
                        </td> --}}
                        <td>
                            <a target="_self" href="{{ route('editCategory',[$row->id,'type'=>$type]) }}" class="btn btn-block btn-outline-success btn-xs" >Edit</a>
                        </td>
                        <td>
                          <input type="hidden" name="type" value="{{ ($type=='') ? '':'main' }}">
                          <button data-url="{{ route('category.destroy',['category'=>$row->id]) }}"  data-id="{{ $row->id }}" class="deleteRecord btn btn-block btn-outline-danger btn-xs" >Delete</button>
                        </td>
					</tr>
                    @php
                      $num++;
                    @endphp
                @endforeach
			</tbody>
			<tfoot>
				<tr>
				<th class="text-center info"><input type="checkbox" name="checkAll" class="checkAll"></th>
					<th>Category Name</th>
					<th>Description</th>
                    @if($type=='')
                       <th>Category Parent</th>
                    @endif
                    <th>Modifier Template</th>
					<th>Image</th>
					<th>Material</th>
					{{-- <th>Sort</th> --}}
					<th>Update</th>
					<th>Delete</th>
				</tr>
			</tfoot>
			</table>
		</div>
	</div>
</div>
</x-backend>

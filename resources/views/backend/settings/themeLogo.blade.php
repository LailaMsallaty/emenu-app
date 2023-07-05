<x-backend>
    <x-alert :errors="$errors" ></x-alert>
<div class="col-xl-10 col-lg-10">
	<div class="card card-primary">
		<div class="card-header">
		<h3 class="card-title">Upload Banner</h3>
		</div>
		<form method="post" action="{{ route('themeLogo.store') }}" enctype="multipart/form-data">
            @csrf
            @method('post')
			<div class="card-body">
				<div class="form-group">
					<label for="exampleInputFile">Upload Banner Image</label>
					<div class="input-group">
						<div class="custom-file">
							<input  type="file" class=" custom-file-input" name="banner_img" >
							<label class="custom-file-label" for="exampleInputFile">Choose file</label>
						</div>
					</div>
				</div>
			</div>
			<div class='item-box '  style="padding:8px;border:1px solid #ddd;width:40%;border-radius:5px;margin:auto;">
                @if($option->getOptionVal('banner_img') !=='')
                   <img src="{{ asset('storage/headers/'.$option->getOptionVal('banner_img')) }}" alt="banner img">
                @else
                    <img src="" alt="">
                @endif
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary" name="upload_banner_btn">Submit</button>
                <button type="submit" class="btn btn-danger" value="1" name="delete_banner">Delete</button>

			</div>
		</form>
	</div>
</div>
<div class="col-xl-10 col-lg-10">
	<div class="card card-primary">
		<div class="card-header">
		<h3 class="card-title">Upload Logo</h3>
		</div>
		<form method="post" action="{{ route('themeLogo.store') }}" enctype="multipart/form-data">
            @csrf
            @method('post')
			<div class="card-body">
				<div class="form-group">
					<label for="exampleInputFile">Upload Logo Image</label>
					<div class="input-group">
						<div class="custom-file">
							<input type="file" class=" custom-file-input"  name="logo_img" >
							<label class="custom-file-label" for="exampleInputFile">Choose file</label>
						</div>
					</div>
				</div>
			</div>
			<div class='item-box'  style="padding:8px;border:1px solid #ddd;width:25%;border-radius:5px;margin:auto;">
             @if($option->getOptionVal('logo_img') !=='')
                <img src="{{ asset('storage/headers/'.$option->getOptionVal('logo_img')) }}" alt="logo img">
             @else
                 <img src="" alt="">
             @endif
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary" name="upload_logo_btn">Submit</button>
                <button type="submit" class="btn btn-danger" value="1" name="delete_logo">Delete</button>
			</div>
		</form>

	</div>
</div>
</x-backend>

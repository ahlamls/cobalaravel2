@include('modular/header')
<h1>Upload</h1>
<hr>
@if (request()->input('error') == 1) 
<div class="alert alert-danger" role="alert">
  Invalid File
</div>
@elseif (request()->input('error') == 2)
<div class="alert alert-danger" role="alert">
  File Not Found
</div>
@endif
<form action="/upload" method="POST"  enctype="multipart/form-data">
@csrf
<div class="mb-3">
  <label for="caption" class="form-label">Caption</label>
  <input type="text" class="form-control" minlength="3" maxlength="32" id="caption" required="" name="caption" placeholder="Describe the image">
</div>
<div class="mb-3">
  <label for="upload" class="form-label">Image (png,jpg,jpeg,gif) (php,html,asp is not an image!)</label>
  <input type="file"class="form-control" accept=".gif,.jpg,.jpeg,.png" id="upload" required="" name="file">
  </div>
<button class="btn btn-success">Upload</button>
<label class="text-muteds">By Clicking the Upload Button . you are agreeing to the Terms of Service of the site</label>
</form>
@include('modular/footer')
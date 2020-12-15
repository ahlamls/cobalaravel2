@include('modular/header')
<h1>Setting</h1>
<hr>
@if (request()->input('error') == 1) 
<div class="alert alert-success" role="alert">
  Setting succesfully changed!
</div>
@elseif (request()->input('error') == 2)
<div class="alert alert-danger" role="alert">
  Failed to change settings
</div>
@endif
<form action="/setting" method="POST"  enctype="multipart/form-data">
@csrf
<div class="mb-3">
  <label for="bio" class="form-label">Bio</label>
  <input rows="3" type="text" class="form-control" value="{{$bio}}" minlength="0" maxlength="128" id="bio" required="" name="bio" placeholder="Describe yourself">
  <div id="emailHelp" class="form-text">Describe yourself . this Bio is shown on your profile page</div>
</div>




<button class="btn btn-success">Submit</button>
</form>
@include('modular/footer')
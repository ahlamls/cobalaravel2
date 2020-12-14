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
  <input rows="3" type="text" class="form-control" minlength="0" maxlength="128" id="bio" required="" name="bio" placeholder="Describe yourself">
  <div id="emailHelp" class="form-text">Describe yourself . this Bio is shown on your profile page</div>
</div>

<div class="mb-3">
<div class="form-check form-switch">
  <input class="form-check-input" name="darkmode" type="checkbox"  id="flexSwitchCheckDefault"  @if (request()->cookie('darkmode') == 1) checked @endif>
  <label class="form-check-label" for="flexSwitchCheckDefault">Dark Mode (Beta)</label>
</div>
<div id="emailHelp" class="form-text">Switch to Dark Theme . better suited for night viewing and OLED display (This setting is stored locally)</div>
</div>

<div class="mb-3">
<div class="form-check form-switch">
  <input class="form-check-input" type="checkbox" name="litemode" id="flexSwitchCheckDefault2"  @if (request()->cookie('litemode') == 1) checked @endif>
  <label class="form-check-label" for="flexSwitchCheckDefault2">Lite Mode (Beta)</label>
</div>
<div id="emailHelp" class="form-text">Load lower quality image . this may make text in the image unreadable (This setting is stored locally)</div>
</div>


<button class="btn btn-success">Submit</button>
</form>
@include('modular/footer')
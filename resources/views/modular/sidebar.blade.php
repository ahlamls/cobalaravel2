<div class="col-md-4 col-12 pad5">
        <h3>About asede</h3>
        <p>it is an image sharing website . all registered user can share the image that they like to share</p>
        <hr>
        <h4>Site Settings</h4>
        <div class="mb-3">
<div class="form-check form-switch">
  <input class="form-check-input" name="darkmode" type="checkbox"  id="darkmode"  @if (request()->cookie('darkmode') == 1) checked @endif>
  <label class="form-check-label" for="flexSwitchCheckDefault">Dark Mode (Beta)</label>
</div>
<div id="emailHelp" class="form-text">Switch to Dark Theme . better suited for night viewing and OLED display (This setting is stored locally)</div>
</div>

<div class="mb-3">
<div class="form-check form-switch">
  <input class="form-check-input" type="checkbox" name="litemode" id="litemode"  @if (request()->cookie('litemode') == 1) checked @endif>
  <label class="form-check-label" for="flexSwitchCheckDefault2">Lite Mode (Beta)</label>
</div>
<div id="emailHelp" class="form-text">Load lower quality image for slower connection and to save data. this may make text in the image unreadable (This setting is stored locally)</div>
</div>

<script>
$( "#darkmode" ).change(function() {
    window.location.href = "/setcookie/1";
});
$( "#litemode" ).change(function() {
    window.location.href = "/setcookie/2";
});
</script>

    </div>
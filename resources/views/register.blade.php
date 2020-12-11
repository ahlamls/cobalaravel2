@include('modular/header')
<h1>Register</h1>
<hr>
@if (request()->input('error') == 1) 
<div class="alert alert-danger" role="alert">
  Email Already Used . Please use a different one . We only allow 1 people per account
</div>
@elseif (request()->input('error') == 2) 
<div class="alert alert-danger" role="alert">
  Username Already Taken . Please use a different one . if you believe your username is stolen please contact us
</div>
@endif
<form action="/register" method="POST">
@csrf
<div class="mb-3">
  <label for="email" class="form-label">Email address (Used for login)</label>
  <input type="email" class="form-control" id="email" required="" name="email" placeholder="name@example.com">
</div>
<div class="mb-3">
  <label for="username" class="form-label">Username (cannot be changed)</label>
  <input type="text" minlength="5" maxlength="16" class="form-control" id="username" required="" name="username" >
</div>
<div class="mb-3">
  <label for="password" class="form-label">Password</label>
  <input type="password" class="form-control" id="password" required="" name="password" placeholder="123456 (most secure password)">
</div>
<div class="mb-3">
  <label for="passwordc" class="form-label">Password (Confirmation)</label>
  <input type="passwordc" class="form-control" id="passwordc" required="" name="passwordc" placeholder="123456 (most secure password)">
</div>
<button class="btn btn-success">Register</button>
</form>
<hr>
<p>Already have an account? <a href="/login" class="btn btn-info">Login</a></p>
@include('modular/footer')
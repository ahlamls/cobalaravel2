@include('modular/header')
<h1>Log In</h1>
<hr>
@if (request()->input('error') == 1) 
<div class="alert alert-danger" role="alert">
  Wrong Email or Password . Please Try Again
</div>
@endif
<form action="/login" method="POST">
@csrf
<div class="mb-3">
  <label for="email" class="form-label">Email address</label>
  <input type="email" class="form-control" id="email" required="" name="email" placeholder="name@example.com">
</div>
<div class="mb-3">
  <label for="password" class="form-label">Password</label>
  <input type="password" class="form-control" id="password" required="" name="password" placeholder="123456 (most secure password)">
</div>
<button class="btn btn-success">Log In</button>
</form>
<hr>
<p>Dont have an account? <a href="/register" class="btn btn-info">Register Now!</a></p>
@include('modular/footer')
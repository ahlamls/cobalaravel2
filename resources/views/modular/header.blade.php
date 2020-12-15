<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/logo.png" />
    <!-- Dark Mode-->
    @if (request()->cookie('darkmode') == 1)
    <style>
    body {
      background:#000000 !important;
      background-color:#000000 !important;
      color:#ffffff !important;
    }
    .card-header {

      background-color: rgba(255,255,255,0.1) !important;
    }
    .card  {

      background-color: #111111 !important;
      color:#ffffff !important;
    } 
    .modal-content  {
background-color: #222222 !important;
color:#ffffff !important;
} 
.text-muteds {
  color:#999999 !important ;
}
.form-control {
  background-color:#444444 !important;
  color:#ffffff !important;
}
    .link
{
   color:white !important;
   
}
::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
  color: #cccccc !important;
  opacity: 1; /* Firefox */
}
.dropdown-menu {
  background-color: #333333 !important;
  color: #ffffff !important;
}
.dropdown-item {
  color: #eeeeee !important;
}

    </style>
    @endif


    <script src="https://kit.fontawesome.com/d6a070d43a.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.6/dist/clipboard.min.js"></script>
    <style>
    .pad5 {
        padding:5px;
    }
    .marg{
        margin:1px;
    }
    .link
{
   color:black;
   text-decoration: none;
   background-color: none;
}
.text-muteds {
  color:#676767;
}
    </style>

   

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    @if (!isset($title))  
    <title>Coba Laravel 2</title>
    @else 
  <title>{{$title}} - Coba Laravel 2</title>
    @endif

    <Meta Content="Coba Laravel 2 is an image sharing website . all registered user can share the image that they like to share" Name=’Description’/>
  </head>
  <body>
  @include('modular/navbar')
  <br>
  <div class="container">

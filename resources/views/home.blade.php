@include('modular/header')
<div class="row">
    <div class="col-md-8 col-12 pad5">
   
{!! $content !!}
@if ($lastpost ?? '' != 0)
<hr>
<a class="btn btn-primary w-100" href="?np={{$lastpost ?? ''}}">More Images..</a>
<br>
@endif
    </div> 

    @include('modular/sidebar')

</div>
@include('modular/footer')
@include('modular/homescript')
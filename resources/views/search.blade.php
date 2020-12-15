@include('modular/header')
<div class="row">
    <div class="col-md-8 col-12 pad5">
    <h1>Search Result for {{ e(request()->input('q')) }}</h1>

    <hr>

{!! $content !!}
@if ($lastpost != 0) 
<hr>
<a class="btn btn-primary w-100" href="?np={{$lastpost ?? ''}}&q={{ e(request()->input('q')) }}">More Images..</a>
<br>
@endif
    </div>

    @include('modular/sidebar')

</div>
@include('modular/footer')
@include('modular/homescript')

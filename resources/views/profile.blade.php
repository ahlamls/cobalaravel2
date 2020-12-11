@include('modular/header')
<div class="row">
    <div class="col-md-8 col-12 pad5">
    @foreach ($profiles as $profile) 
   <h1><i class='fas fa-user'></i>  {{ $profile->username}}</h1>
   <p>{{$profile->bio}}</p>
   <p class="text-muted">Joined : {{ substr($profile->time,0,10)}}</p>
   <hr>
@endforeach
{!! $content !!}
    </div> 

    @include('modular/sidebar')

</div>
@include('modular/footer')
@include('modular/header')
<div class="row">
    <div class="col-md-8 col-12 pad5">
    @foreach ($profiles as $profile)
    <?php 
  if ($profile->verified == 1) {
    $verifiedh = "<i class='fas fa-check-circle'></i>";
} else {
    $verifiedh = "";
}
    ?>
   <h1><i class='fas fa-user'></i>  {{ $profile->username}} {!! $verifiedh !!}</h1>
   <p>{{$profile->bio}}</p>
   <p class="text-muteds">Joined : {{ substr($profile->time,0,10)}}</p>
   @if ($profile->verified == 1) 
   <span class="badge bg-primary">Verified User</span>
   @endif
   
@endforeach
{!! $content !!}
@if ($lastpost != 0) 
<hr>
<a class="btn btn-primary w-100" href="?np={{$lastpost ?? ''}}">More Images..</a>
<br>
@endif
    </div>

    @include('modular/sidebar')

</div>
@include('modular/footer')
@include('modular/homescript')

@extends('layouts.app')
@section('title','Library')

@section('content')
<div class="container">
  @include('includes.parts.msg')
  @include('includes.parts.err')
</div>

<!-- Heading Container -->
<div class="container">
<h1 style="margin:10px;margin-left:30px;font-size:4rem;">Library <span style="font-size:1.5rem;color:#6c757d;">Visit Other Department And See What They Are Studying</span></h1>
<div class="row">
  <div class="col-md-6 text-center">
    <div class="dropdown" style="margin:25px;width:100%;">
        <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-info btn-lg" data-target="#" href="/page.html" style="width:100%;">
            Visit Other Location <span class="caret"></span>
        </a>
        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu" style="min-width:70%;">
          <li><a class="dropdown-item" href="{{ route('library') }}">My Current Stage</a></li>
          @foreach($departments as $dept)
          <li class="dropdown-submenu ">
            <a class="dropdown-item" tabindex="-1" href="">{{ $dept->department_name }}</a>
            <ul class="dropdown-menu">
              @foreach($stages as $stg)
                @if($dept->id === $stg->department_id)
                  <li><a class="dropdown-item" tabindex="-1" href="{{ route('library.lib',['department_slug' => $dept->slug, 'stage_id' => $stg->id ]) }}"><i class="fa fa-graduation-cap"></i> {{ $stg->stage_name }}</a></li>
                @endif
              @endforeach
            </ul>
          </li>
          @endforeach
        </ul>
    </div>
  </div>
  <div class="col-md-6 text-center">
    <div class="lds-ripple"><div></div><div></div></div>
  </div>
</div>
</div>

<!-- Content Container -->
<div class="container-fluid" style="min-height:100vh;">
  @if(isset($subjects) && !isset($custom_subjects))
    <h2 class="text-center" style="margin:20px;font-size:2rem;">From My Current Stage</h2>
  @elseif(isset($custom_subjects) && !isset($subjects))
    <h2 class="text-center" style="margin:20px;font-size:2rem;">From {{ $department_name }} <i class="fa fa-arrow-right"></i> {{ $stage_name }} </h2>
  @endif

  <div class="row">
    <!-- Subjects -->
    @if(isset($subjects) && !isset($custom_subjects))
      @forelse($subjects as $subject)
      <div class="col-md-4">
        <div class="fcards">
          <div class="cards" style="margin-top: 10px;margin-bottom: 10px;">
            <div class="front" style="background-image: url('{{ Request::root() }}/data/subjects/covers/{{ $subject->cover }}');">
              <div class="inner">
                <p>{{ $subject->subject_name }}</p>
                <span>{{ $subject->teacher_name }}</span>
              </div>
            </div>
            <div class="back">
              <div class="inner">
                <a href="{{ route('library.sub',['subject_slug' => $subject->slug, 'depID' => $subject->department_id, 'stgID' => $subject->stage_id]) }}" class="btn btn-primary">Browse</a>
                <a href="{{ route('browse.sub_view',['subject_slug' => $subject->slug]) }}" target="_blank" class="btn btn-primary">Review</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      @empty
      <div class="col-md-12">
        <h3 class="text-center">No Subjects Her <i class="fa fa-meh-o"></i></h3>
      </div>
      @endforelse
    @endif

    <!-- Custom Subjects -->
    @if(isset($custom_subjects) && !isset($subjects))
      @forelse($custom_subjects as $subject)
      <div class="col-md-4">
        <div class="fcards">
          <div class="cards" style="margin-top: 10px;margin-bottom: 10px;">
            <div class="front" style="background-image: url('{{ Request::root() }}/data/subjects/covers/{{ $subject->cover }}');">
              <div class="inner">
                <p>{{ $subject->subject_name }}</p>
                <span>{{ $subject->teacher_name }}</span>
              </div>
            </div>
            <div class="back">
              <div class="inner">
                <a href="{{ route('library.sub',['subject_slug' => $subject->slug, 'depID' => $subject->department_id, 'stgID' => $subject->stage_id]) }}" class="btn btn-primary">Browse</a>
                <a href="{{ route('browse.sub_view',['subject_slug' => $subject->slug]) }}" target="_blank" class="btn btn-primary">Review</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      @empty
      <div class="col-md-12">
        <h3 class="text-center">No Subjects Her <i class="fa fa-meh-o"></i></h3>
      </div>
      @endforelse
    @endif
  </div>
</div>



@stop

@section('css')
<style media="screen">

/* Dropdown Multi Level Style Start */
.btn-info {
  background-color: #343a40!important;
  color: #fff!important;
  text-transform: initial;
  font-size: 1.3rem !important;
}
.btn-info:hover {
  background-color: #333!important;
}

.dropdown-menu {
  box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
  border-radius: 0px;
  border-top: 2px solid #222;
}
.dropdown-item:focus, .dropdown-item:hover {
    color: #dee2e6;
    text-decoration: none;
    background-color: #343a40;
}

.dropdown-submenu {
    position: relative;
}

.dropdown-submenu>.dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -6px;
    margin-left: -1px;
    -webkit-border-radius: 0 6px 6px 6px;
    -moz-border-radius: 0 6px 6px;
    border-radius: 0px;
}

.dropdown-submenu:hover>.dropdown-menu {
    display: block;
}

.dropdown-submenu>a:after {
    display: block;
    content: " ";
    float: right;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
    border-width: 5px 0 5px 5px;
    border-left-color: #ccc;
    margin-top: 5px;
    margin-right: -10px;
}

.dropdown-submenu:hover>a:after {
    border-left-color: #fff;
}

.dropdown-submenu.pull-left {
    float: none;
}

.dropdown-submenu.pull-left>.dropdown-menu {
    left: -100%;
    margin-left: 10px;
    -webkit-border-radius: 6px 0 6px 6px;
    -moz-border-radius: 6px 0 6px 6px;
    border-radius: 6px 0 6px 6px;
}
/* Dropdown Multi Level Style End */

/* Head Loader Start */
.lds-ripple {
  display: inline-block;
  position: relative;
  width: 64px;
  height: 64px;
  margin-top:30px;
}
.lds-ripple div {
  position: absolute;
  border: 4px solid #212121;
  opacity: 1;
  border-radius: 50%;
  animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
}
.lds-ripple div:nth-child(2) {
  animation-delay: -0.5s;
}
@keyframes lds-ripple {
  0% {
    top: 28px;
    left: 28px;
    width: 0;
    height: 0;
    opacity: 1;
  }
  100% {
    top: -1px;
    left: -1px;
    width: 58px;
    height: 58px;
    opacity: 0;
  }
}
/* Head Loader End  */

/* Cards Start */
.btn-primary {
  width: 200px;
  background-color: #343a40!important;
  font-size:1.1rem;
  text-transform: initial;
}
.btn-primary:hover {
  background-color: #333 !important;
}

.fcards {
  padding: 10px;
}

.cards {
  -webkit-transform-style: preserve-3d;
   transform-style: preserve-3d;
  -webkit-perspective: 1000px;
   perspective: 1000px;
}

.front,
.back{
  background-size: cover;
	background-position: center;
	-webkit-transition: -webkit-transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
	transition: -webkit-transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
	-o-transition: transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
	transition: transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
	transition: transform .7s cubic-bezier(0.4, 0.2, 0.2, 1), -webkit-transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
	-webkit-backface-visibility: hidden;
	        backface-visibility: hidden;
	text-align: center;
	min-height: 280px;
	height: auto;
	border-radius: 10px;
	color: #fff;
	font-size: 1.5rem;
}

.back{
  background: #cedce7;
  background: -webkit-linear-gradient(45deg, #2e2e2e 0%,#dee2e6 100%);
  background: -o-linear-gradient(45deg, #2e2e2e 0%,#dee2e6 100%);
  background: linear-gradient(45deg, #2e2e2e 0%,#dee2e6 100%);
}

.front:after{
	position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
    width: 100%;
    height: 100%;
    content: '';
    display: block;
    opacity: .6;
    background-color: #000;
    -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
    border-radius: 10px;
}

.cards:hover .front,
.cards:hover .back{
    -webkit-transition: -webkit-transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
    transition: -webkit-transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
    -o-transition: transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
    transition: transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
    transition: transform .7s cubic-bezier(0.4, 0.2, 0.2, 1), -webkit-transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
}

.back{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
}

.inner{
    -webkit-transform: translateY(-50%) translateZ(60px) scale(0.94);
            transform: translateY(-50%) translateZ(60px) scale(0.94);
    top: 50%;
    position: absolute;
    left: 0;
    width: 100%;
    padding: 2rem;
    -webkit-box-sizing: border-box;
            box-sizing: border-box;
    outline: 1px solid transparent;
    -webkit-perspective: inherit;
            perspective: inherit;
    z-index: 2;
}

.cards .back{
    -webkit-transform: rotateY(180deg);
            transform: rotateY(180deg);
    -webkit-transform-style: preserve-3d;
            transform-style: preserve-3d;
}

.cards .front{
    -webkit-transform: rotateY(0deg);
            transform: rotateY(0deg);
    -webkit-transform-style: preserve-3d;
            transform-style: preserve-3d;
}

.cards:hover .back{
  -webkit-transform: rotateY(0deg);
          transform: rotateY(0deg);
  -webkit-transform-style: preserve-3d;
          transform-style: preserve-3d;
}

.cards:hover .front{
  -webkit-transform: rotateY(-180deg);
          transform: rotateY(-180deg);
  -webkit-transform-style: preserve-3d;
          transform-style: preserve-3d;
}

.front .inner p{
  font-size: 25px;
  margin-bottom: 2rem;
  position: relative;
}

.front .inner p:after{
  content: '';
  width: 4rem;
  height: 2px;
  position: absolute;
  background: #C6D4DF;
  display: block;
  left: 0;
  right: 0;
  margin: 0 auto;
  bottom: -.75rem;
}

.front .inner span{
  color: white /*rgba(255,255,255,0.7) */;
  font-weight: 300;
}
/* Cards End */
</style>
@stop

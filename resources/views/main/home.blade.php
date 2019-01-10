@extends('layouts.app')
@section('title','Home')

@section('content')
<div class="container">
  @include('includes.parts.msg')
  @include('includes.parts.err')
</div>




<div class="container">
    @if(!empty(Auth::user()->department_id) && !empty(Auth::user()->stage_id))
        <div class="word"></div>
    @else
        <center>
            <h1 class="text-center" style="margin-top:80px;">اكمل معلومات حسابك</h1>
            <a href="{{ route('profile.my_profile') }}" class="btn btn-primary btnh" style="width: 200px; background-color: #3f51b5!important;font-size:1.1rem;text-transform: initial;">Profile</a>
        </center>
    @endif
</div>



<div class="container" style="min-height: 88.5vh;">
  @if(Auth::user()->department_id != '' && Auth::user()->stage_id != '')
  <!--<h1 style="margin:15px;font-size: 2.5rem; font-weight: 100;text-align:center;margin-top:50px;">Welcome Back <i class="fa fa-slack"></i> This is Your Current Stage Subjects</h1>-->
  <!--<p style="margin:15px;font-size: 1.5rem; font-weight: 100;text-align:center;"> <i class="fa fa-plug"></i> These are all the subjects for your current stage that you can browse, download and add to your own bag</p>-->
    <div class="row">
      @if(count($subjects) > 0)
        @foreach($subjects as $subject)
          <div class="col-md-6">
              <div class="blog-card">
                	<div class="meta">
                		<div class="photo" style="background-image: url('{{ Request::root() }}/data/subjects/covers/{{ $subject->cover }}')"></div>
                		<ul class="details">
                			<li class="author"><a href="#">{{ $subject->teacher_name }}</a></li>
                            <li class="date"><a href="#">{{ $subject->stage->stage_name }}</a></li>
                		</ul>
                	</div>
                	<div class="description">
                		<h1>{{ $subject->subject_name }}</h1>
                		<h2>{{ $subject->department->department_name }}</h2>
                		<p></p>
                		<p class="read-more">
                			<a href="{{ route('browse.index',['subject_slug' => $subject->slug]) }}">Browse</a> |
                            <a href="{{ route('browse.sub_view',['subject_slug' => $subject->slug]) }}">Review</a>
                		</p>
                	</div>
                </div>

          </div>
        @endforeach
      @else
        <center>
          <h2 style="margin:30px;font-size: 2rem; font-weight: 100;">NO SUBJECTS IN YOUR STAGE NOW <i class="fa fa-smile-o"></i></h2>
        </center>
      @endif
    </div>
  @else
    <center>
      <h1 style="margin:30px;font-size: 2rem; font-weight: 100;">No Data For You Now Try Search or Coming Soon <i class="fa fa-smile-o"></i> </h1>
      <a href="{{ route('order') }}" class="btn btn-primary btnh" style="width: 200px; background-color: #3f51b5!important;font-size:1.1rem;text-transform: initial;">Order</a>
      <a href="{{ route('search.index') }}" class="btn btn-primary btnh" style="width: 200px; background-color: #3f51b5!important;font-size:1.1rem;text-transform: initial;">Search</a>
    </center>
  @endif
</div>



@stop


@section('js')
<script type="text/javascript">
$(function(){

    var
  words = [
      'مرحبا بك مره أخرى',
      'هذه هي المواد الخاصه بمرحلتك الدراسيه',
      'يمكنك تصفحها والدراسه مع زملائك',
      'لاتنس ان تتفقد حقيبتك الالكترونيه بين الحين والأخر',
  ],
  part,
  i = 0,
  offset = 0,
  len = words.length,
  forwards = true,
  skip_count = 0,
  skip_delay = 5,
  speed = 100;

var wordflick = function(){
  setInterval(function(){
      if (forwards) {
        if(offset >= words[i].length){
          ++skip_count;
          if (skip_count == skip_delay) {
            forwards = false;
            skip_count = 0;
          }
        }
      }
      else {
         if(offset == 0){
            forwards = true;
            i++;
            offset = 0;
            if(i >= len){
              i=0;
            }
         }
      }
      part = words[i].substr(0, offset);
      if (skip_count == 0) {
        if (forwards) {
          offset++;
        }
        else {
          offset--;
        }
      }
    	$('.word').text(part);
  },speed);
};

$(document).ready(function(){
  wordflick();
});

});
</script>
@stop


@section('css')
<style media="screen">



.word {
  margin-top: 20px;
  margin-bottom: 20px;
  color: #222;
  font-size:4rem;
  text-align: right;
  display: block;
  min-height: 120px;
}


/* Subjects Cards */

.blog-card {
  display: flex;
  flex-direction: column;
  margin: 1rem auto;
  box-shadow: 0 3px 7px -1px rgba(0, 0, 0, 0.1);
  margin-bottom: 1.6%;
  background: #fff;
  line-height: 1.4;
  font-family: sans-serif;
  border-radius: 5px;
  overflow: hidden;
  z-index: 0;
}
.blog-card a {
  color: inherit;
}
.blog-card a:hover {
  color: #5ad67d;
}
.blog-card:hover .photo {
  -webkit-transform: scale(1.3) rotate(3deg);
          transform: scale(1.3) rotate(3deg);
}
.blog-card .meta {
  position: relative;
  z-index: 0;
  height: 200px;
}
.blog-card .photo {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background-size: cover;
  background-position: center;
  transition: -webkit-transform .2s;
  transition: transform .2s;
  transition: transform .2s, -webkit-transform .2s;
}
.blog-card .details,
.blog-card .details ul {
  margin: auto;
  padding: 0;
  list-style: none;
}
.blog-card .details {
  position: absolute;
  top: 0;
  bottom: 0;
  left: -100%;
  margin: auto;
  transition: left .2s;
  background: rgba(0, 0, 0, 0.6);
  color: #fff;
  padding: 10px;
  width: 100%;
  font-size: .9rem;
}
.blog-card .details a {
  -webkit-text-decoration: dotted underline;
          text-decoration: dotted underline;
}
.blog-card .details ul li {
  display: inline-block;
}
.blog-card .details .author:before {
  font-family: FontAwesome;
  margin-right: 10px;
  content: "\f007";
}
.blog-card .details .date:before {
  font-family: FontAwesome;
  margin-right: 10px;
  content: "\f133";
}
.blog-card .details .tags ul:before {
  font-family: FontAwesome;
  content: "\f02b";
  margin-right: 10px;
}
.blog-card .details .tags li {
  margin-right: 2px;
}
.blog-card .details .tags li:first-child {
  margin-left: -4px;
}
.blog-card .description {
  padding: 1rem;
  background: #fff;
  position: relative;
  z-index: 1;
}
.blog-card .description h1,
.blog-card .description h2 {
  font-family: Poppins, sans-serif;
}
.blog-card .description h1 {
  line-height: 1;
  margin: 0;
  font-size: 1.7rem;
}
.blog-card .description h2 {
  font-size: 1rem;
  font-weight: 300;
  text-transform: uppercase;
  color: #a2a2a2;
  margin-top: 5px;
}
.blog-card .description .read-more {
  text-align: right;
}
.blog-card .description .read-more a {
  color: #5ad67d;
  display: inline-block;
  position: relative;
}
.blog-card .description .read-more a:after {
  content: "\f061";
  font-family: FontAwesome;
  margin-left: -10px;
  opacity: 0;
  vertical-align: middle;
  transition: margin .3s, opacity .3s;
}
.blog-card .description .read-more a:hover:after {
  margin-left: 5px;
  opacity: 1;
}
.blog-card p {
  position: relative;
  margin: 1rem 0 0;
}
.blog-card p:first-of-type {
  margin-top: 1.25rem;
}
.blog-card p:first-of-type:before {
  content: "";
  position: absolute;
  height: 5px;
  background: #5ad67d;
  width: 35px;
  top: -0.75rem;
  border-radius: 3px;
}
.blog-card:hover .details {
  left: 0%;
}
@media (min-width: 640px) {
  .blog-card {
    flex-direction: row;
    max-width: 700px;
  }
  .blog-card .meta {
    flex-basis: 40%;
    height: auto;
  }
  .blog-card .description {
    flex-basis: 60%;
  }
  .blog-card .description:before {
    -webkit-transform: skewX(-3deg);
            transform: skewX(-3deg);
    content: "";
    background: #fff;
    width: 30px;
    position: absolute;
    left: -10px;
    top: 0;
    bottom: 0;
    z-index: -1;
  }
  .blog-card.alt {
    flex-direction: row-reverse;
  }
  .blog-card.alt .description:before {
    left: inherit;
    right: -10px;
    -webkit-transform: skew(3deg);
            transform: skew(3deg);
  }
  .blog-card.alt .details {
    padding-left: 25px;
  }
}


/* Subjects Cards End */

.hover-on-card:hover {
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1), 0 6px 40px 0 rgba(0, 0, 0, 0.1);
}






</style>

@stop

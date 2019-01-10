@extends('adminlte::page')

@section('title','EASS Subjects')

@section('content_header')
@include('includes.parts.msg')
@include('includes.parts.err')


<center>
  <h1 style="font-weight:700;font-size:45px;">Subjects</h1>
  <h3>{{ $dept_name->department_name }} <i class="fa fa-tags"></i> {{ $stg_name->stage_name }}</h3>
  <a href="{{ route('subjects.start') }}" class="btn btn-default btn-sm bg-purple" style="width: 185px;">BROWSE OTHER</a>
  <a href="{{ route('subjects.add_view') }}" class="btn btn-default btn-sm bg-purple" style="width: 185px;">ADD NEW SUBJECT</a>
</center>


<hr>
@stop

@section('content')
<div class="content">
  <div class="row">
    @if(count($subjects) > 0)
      @foreach($subjects as $subject)
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
                  <p>{{ $subject->discription }}.</p>
                </div>
              </div>
            </div>
            <div class="text-center">
              <div class="btn-group">
                <a href="{{ route('subjects.edit_view',['slug' => $subject->slug]) }}" class="btn btn-default btn-flat btn-sm" style="width:75px;"><i class="fa fa-edit"></i> Edit</a>
                <a href="{{ route('subjects.view_subject',['slug' => $subject->slug]) }}" class="btn btn-default btn-flat btn-sm" style="width:75px;"><i class="fa fa-table"></i> View</a>
                <a href="{{ route('subjects.delete',['slug' => $subject->slug]) }}" onclick="return confirm('Are you sure you delete this subject ? Can not restore any data after the deletions . Take care of your triggeration in such operations .')" class="btn btn-default btn-flat btn-sm" style="width:75px;"><i class="fa fa-trash"></i> Delete</a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    @else
      <center>
        <h2>No Subjects <i class="fa fa-smile-o"></i></h2>
      </center>
    @endif
  </div>
</div>
@stop



@section('js')
<script type="text/javascript">

</script>
@stop

@section('css')

<style media="screen">

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
  background: -webkit-linear-gradient(45deg,  #cedce7 0%,#596a72 100%);
  background: -o-linear-gradient(45deg,  #cedce7 0%,#596a72 100%);
  background: linear-gradient(45deg,  #cedce7 0%,#596a72 100%);
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


</style>

<style media="screen">
  /* body{font-family: Segoe UI;} */
  .content-wrapper {background-color: white;}
</style>
@stop

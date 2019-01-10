@extends('layouts.app')
@section('title')
{{ $subject->subjectname }}
@stop

@section('content')

<div class="container" style="min-height:100vh;">
  <div class="row">
    <div class="col-md-6 text-center">
      <h1 style="font-size: 3.3rem;font-weight: 100;color: black;display: block;width: 100%;margin: 10px;margin-top:30px;">{{ $subject->subjectname }}</h1>
      <h3 style="font-size: 2rem;font-weight: 100;color: black;display: block;width: 100%;margin: 10px;">{{ $subject->departmentname }} <i class="fa fa-arrow-right"></i> {{ $subject->stagename }}</h3>
      <span>__</span>
      <h4> <i class="fa fa-user-o"></i> {{ $subject->subjectteacher }}</h4>
      @if(Auth::user()->role === 'Owner' || Auth::user()->role === 'Administrator')
        <div style="margin-top:10px;">
          <a target="_blank" rel="noopener noreferrer" href="{{ route('subjects.view_subject',['slug' => $subject->subjectslug]) }}" class="btn btn-info"> <i class="fa fa-gear"></i> More Actions</a>
        </div>
      @endif
    </div>
    <div class="col-md-6 text-center">
      <img class="img-thumbnail" style="max-width:400px; max-height:500px; margin-top:20px" src="{{ Request::root() }}/data/subjects/covers/{{ $subject->subjectcover }}" alt="Subject Cover">
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <p style="margin-top: 4rem;font-size:1.3rem;">{{  $subject->subjectdiscription }}.</p>
    </div>
  </div>
</div>

@stop






@section('css')

<style media="screen">

.ph {
  margin-top: 11px;
  margin-bottom: 11px;
  padding: 3px;
  min-height: 50px;
  background: -webkit-linear-gradient(315deg, #8254EA 0%, #E86DEC 100%);
  background: linear-gradient(135deg, #8254EA 0%, #E86DEC 100%);
  border-radius: 0.25rem;

}
.ph .btn-ph {
  background-color: #b760e8 !important;
  text-transform: initial;
  font-size: 1rem;
  min-width: 200px;
  transition: all .4s;
}
.ph .btn-ph:hover {
  background-color: #764e8c !important;
}
</style>
@stop

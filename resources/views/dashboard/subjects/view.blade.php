@extends('adminlte::page')

@section('title', 'EASS Subjects')

@section('content_header')
@include('includes.parts.msg')
@include('includes.parts.err')


<div class="row">
  <div class="col-md-6 text-center">
    <h1 style="font-weight:700;font-size:45px;">{{ $subject->subjectname }}</h1>
    <h3>{{ $subject->departmentname }} <i class="fa fa-tags"></i> {{ $subject->stagename }}</h3>
    <span>__</span>
    <h4>{{ $subject->subjectteacher }}</h4>
    <div class="btn-group">
      <a href="{{ route('subjects.brows', ['dept' => $subject->departmentslug, 'stg' => $subject->stageid]) }}" class="btn btn-default btn-flat btn-sm" style="width:100px;"><i class="fa fa-arrow-left"></i> Go Back</a>
      <a href="{{ route('subjects.edit_view',['slug' => $subject->subjectslug]) }}" class="btn btn-default btn-flat btn-sm" style="width:100px;"><i class="fa fa-edit"></i> Edit</a>
      <a href="{{ route('subjects.delete',['slug' => $subject->subjectslug]) }}" onclick="return confirm('Are you sure you delete this subject ? Can not restore any data after the deletions . Take care of your triggeration in such operations . ')" class="btn btn-default btn-flat btn-sm" style="width:100px;"><i class="fa fa-trash"></i> Delete</a>
      <a href="{{ route('items.index',['showState' => 'all','sub' => $subject->subjectslug]) }}" class="btn btn-default btn-flat btn-sm" style="width:100px;"><i class="fa fa-tags"></i> {{$items_counter}} Items</a>
      <a href="{{ route('items.upload_edit_view', ['view' => 'upload', 'dept' => $subject->sdeptid, 'stg' => $subject->sstgid, 'sub' => $subject->subjectid]) }}" class="btn btn-default btn-flat btn-sm" style="width:100px;"><i class="fa fa-upload"></i> Upload</a>

    </div>
  </div>
  <div class="col-md-6 text-center">
    <img class="img-thumbnail" style="max-width:400px; max-height:500px;" src="{{ Request::root() }}/data/subjects/covers/{{ $subject->subjectcover }}" alt="Subject Cover">
  </div>
</div>
<hr>
<p class="text-center">{{  $subject->subjectdiscription }}.</p>
@stop

@section('content')
<div class="content">

  @if($items_counter > 0)
    <h2>{{ $items_counter }} ITEM IN THIS SUBJECT</h2>


    <div class="box box-danger" style="border-radius: 0px;">
      <div class="box-header">
        ITEMS BY CATEGORY
      </div>
      <div class="box-body">
        @foreach($categories as $cat)
          <a href="{{ route('items.index',['showState' => 'category','sub' => $subject->subjectslug, 'cat' => $cat->slug]) }}" class="btn btn-danger btn-sm" style="margin-top: 3px;"><i class="fa fa-tag"></i>  {{ $cat->category_name }}</a>
        @endforeach
      </div>
    </div>


    <div class="box box-info" style="border-radius: 0px;">
      <div class="box-header">
        ITEMS BY STUDY YEAR
      </div>
      <div class="box-body">
        <div class="">
          @foreach($years as $year)
            <a href="{{ route('items.index',['showState' => 'year','sub' => $subject->subjectslug, 'yr' => $year->the_year]) }}" class="btn btn-info btn-sm" style="margin-top: 3px;"><i class="fa fa-calendar-check-o"></i> {{ $year->the_year }}</a>
          @endforeach
        </div>
      </div>
    </div>

    <div class="box box-success" style="border-radius: 0px;">
      <div class="box-header">
        ITEMS BY CATEGORY & YEAR
      </div>
      <div class="box-body">
          @foreach($categories as $cat)
            <div style="padding: 10px; border: 1px solid #EEE; border-radius: 1px; background-color:#EEE; margin:5px;">
              <h5>{{ $cat->category_name }}</h5>
              @foreach($years as $year)
                <a href="{{ route('items.index',['showState' => 'category-and-year','sub' => $subject->subjectslug, 'cat' => $cat->slug, 'yr' => $year->the_year]) }}" class="btn btn-success btn-sm" style="margin-top: 3px;"><i class="fa fa-calendar-check-o"></i> {{ $year->the_year }}</a>
              @endforeach
            </div>
          @endforeach
      </div>
    </div>

  @else
    <h2>NO ITEMS IN THIS SUBJECT <i class="fa fa-smile-o"></i> </h2>
  @endif
</div>
@stop




@section('css')
<style media="screen">
  /* body{font-family: Segoe UI;} */
  .content-wrapper {background-color: white;}
</style>
@stop

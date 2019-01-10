@extends('adminlte::page')

@section('title', 'EASS Subjects')
@section('content_header')
@include('includes.parts.msg')
@include('includes.parts.err')

<center>
  <h1 style="font-weight:700;font-size:45px;">Edit {{ $item_data->title }} </h1>
  <h4>{{ $department->department_name }} <i class="fa fa-arrow-right"></i> {{ $stage->stage_name }} <i class="fa fa-arrow-right"></i> {{ $subject->subject_name }}</h4>
  <a href="{{ route('subjects.view_subject',['slug' => $subject->slug]) }}" class="btn btn-default btn-sm bg-purple" style="width:185px;"><i class="fa fa-arrow-left"></i> Back to Subject</a>
  <!--<a href="{{ URL::previous() }}" class="btn btn-default btn-sm bg-purple" style="width:185px;"><i class="fa fa-arrow-left"></i> Back to Previous</a>-->
</center>




@stop

@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
      <div class="upload-screen">
        <h2 class="text-center"><i class="fa fa-edit"></i></h2>
        <h6 class="text-center">Can not edit category or year .. if you need edit it please delete item and upload again !</h6>
        <hr>
        <form class="" action="{{ route('items.edit') }}" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}

          <input type="password" name="id" value="{{ $item_data->id }}" style="display:none;">

          <div class="form-group">
            <label>Title</label>
            <input value="{{ $item_data->title }}" type="text" name="title" class="form-control" placeholder="Write Title Her ..." required autocomplete="off">
          </div>

          <div class="form-group">
            <label>Discription</label>
            <textarea class="form-control" name="discription" rows="8" cols="80" required autocomplete="off" placeholder="Write Discription Her ..."> {{ $item_data->discription }} </textarea>
          </div>

          <div class="form-group">
            <label>File</label>
            <input type="password" name="oldfile" value="{{ $item_data->file }}" style="display:none;">
            <input type="file" name="file">
            <h6>Leave the file empty if you dont need upload another file !</h6>
            <h6>Can Upload The <span style="color:red;">PDF</span> or <span style="color:blue;">WORD</span> or <span style="color:green;">EXCEL</span> or <span style="color:orange;">POWER POINT</span> and other</h6>
          </div>

          <button type="submit" name="submit" class="btn btn-default btn-block bg-purple"><i class="fa fa-upload"></i> Save</button>

        </form>
      </div>
    </div>
    <div class="col-md-3"></div>
  </div>
</div>
@stop




@section('css')
<style media="screen">
  /* body{font-family: Segoe UI;} */
  .content-wrapper {background-color: white;}
  .upload-screen {
    background-color: #f4f4f4;
    padding: 14px;
    margin: 0px;
    border: 1px solid #eee;
    border-radius: 4px;
  }


  hr {
    margin-top: 15px;
    margin-bottom: 15px;
    border: 0;
    border-top: 1px solid #d2d6de;
}
</style>
@stop

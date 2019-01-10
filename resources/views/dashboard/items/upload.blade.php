@extends('adminlte::page')

@section('title', 'EASS Subjects')

@section('content_header')
@include('includes.parts.msg')
@include('includes.parts.err')


<center>
  <h1 style="font-weight:700;font-size:45px;">UPLOAD</h1>
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
        <h2 class="text-center"><i class="fa fa-upload"></i></h2>
        <hr>
        <form class="" action="{{ route('items.upload') }}" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input style="display:none;" type="password" name="department_id" value="{{ $department->id }}">
          <input style="display:none;" type="password" name="stage_id" value="{{ $stage->id }}">
          <input style="display:none;" type="password" name="subject_id" value="{{ $subject->id }}">

          <div class="form-group">
            <label>File</label>
            <input type="file" name="file" required>
            <h6>Can Upload The <span style="color:red;">PDF</span> or <span style="color:blue;">WORD</span> or <span style="color:green;">EXCEL</span> or <span style="color:orange;">POWER POINT</span> and other</h6>
          </div>

          <div class="form-group">
            <label>Category</label>
            <select class="form-control" name="category_id">
              <option value="empty">Please Chose Category</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label>Study Year</label>
            <select class="form-control" name="year">
              <option value="empty">Please Chose Study Year</option>
              @foreach($years as $yr)
                <option value="{{ $yr->the_year }}">{{ $yr->the_year }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" placeholder="Write Title Her ..." required autocomplete="off">
          </div>

          <div class="form-group">
            <label>Discription</label>
            <textarea class="form-control" name="discription" rows="8" cols="80" required autocomplete="off" placeholder="Write Discription Her ..."></textarea>
          </div>



          <button type="submit" name="submit" class="btn btn-default btn-block bg-purple"><i class="fa fa-upload"></i> Save & Upload</button>

        </form>
      </div>
    </div>
    <div class="col-md-3"></div>
  </div>
</div>
@stop




@section('css')s
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

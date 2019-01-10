@extends('adminlte::page')

@section('title', 'EASS Subjects')

@section('content_header')
@include('includes.parts.msg')
@include('includes.parts.err')


<center>
  <h1 style="font-weight:700;font-size:45px;">Edit {{ $subject->subjectname }}</h1>
  <a href="{{ URL::previous() }}" class="btn btn-default btn-sm bg-purple" style="width: 185px;">GO BACK</a>
  <a href="{{ route('subjects.add_view') }}" class="btn btn-default btn-sm bg-purple" style="width: 185px;">ADD NEW</a>
  <a href="{{ route('subjects.start') }}" class="btn btn-default btn-sm bg-purple" style="width: 185px;">BROWSE</a>
</center>


<hr>
@stop

@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
      <div class="screen">
        <h3>Edit Subject</h3>
        <h6>Can not edit Department and Stage .. if you need update it please delete subject and add agin in another Department and Stage !</h6>
        <form  action="{{ route('subjects.edit') }}" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}

          <input type="password" name="id" value="{{ $subject->subjectid }}" style="display:none;">

          <div class="form-group">
            <label>Subject name</label>
            <input value="{{ $subject->subjectname }}" type="text" name="subject_name" class="form-control" placeholder="Enter Subject name" required autocomplete="off">
          </div>


          <div class="form-group">
            <label>Subject Teacher</label>
            <input value="{{ $subject->subjectteacher }}" type="text" name="teacher_name" value="Unknwon Teacher" class="form-control" placeholder="Enter Teacher Name" required autocomplete="off">
          </div>

          <div class="form-group">
            <label>Subject Description</label>
            <textarea name="discription" rows="8" cols="80" class="form-control" required autocomplete="off" placeholder="Write Description of thes subject ...">{{ $subject->subjectdiscription }}</textarea>
          </div>

          <div class="form-group">
            <label>Chose Cover</label>
            <input type="file" name="cover">
            <h6>Leave the cover empty if he does not want to update it !</h6>
            <h6>You can put cover photo of the type : <span style="color:green;">JPG , PNG</span> </h6>
          </div>

          <input type="password" name="oldcover" value="{{ $subject->subjectcover }}" style="display:none;">

          <button type="submit" name="submit" class="btn btn-default bg-purple btn-block"><i class="fa fa-save"></i> Save changes</button>
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

.screen {
  margin: 0px;
  padding: 14px;
  background: #f4f4f4;
  border:1px solid #EEE;
  border-radius: 4px;
}
</style>
@stop

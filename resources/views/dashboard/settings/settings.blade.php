@extends('adminlte::page')

@section('title', 'EASS Settings')

@section('content_header')
@include('includes.parts.msg')
@include('includes.parts.err')

<center>
  <h1 style="font-family: Segoe UI; font-weight:700;font-size:45px;">Settings</h1>
</center>


@stop

@section('content')
<div class="content">

  <!-- Add Setting Modal -->
  <div class="modal fade" id="modal-default" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button class="close" aria-label="Close" type="button" data-dismiss="modal">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Add Settings</h4>
          </div>
          <div class="modal-body">
            <form id="new-setting-form" action="{{ route('settings.store') }}" method="POST">
              {{ csrf_field() }}
              <div class="form-group">
                <input class="form-control" type="text" placeholder="Setting name ... " name="name" required autocomplete="off">
              </div>
              <div class="form-group">
                  <input class="form-control" type="text" placeholder="Setting value ... " name="value" required autocomplete="off">
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button class="btn btn-default pull-left" type="button" data-dismiss="modal">Cancel</button>
            <button onclick="document.getElementById('new-setting-form').submit();" class="btn btn-primary" type="button">Save Setting</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- ************* -->

  <div class="box box-primary" style="border-top-color: #605ca8; border-radius: 0px;">
    <div class="card-header">
        <button style="margin:10px;" class="btn btn-default" type="button" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> New Setting</button>
    </div>

    <div class="box-body">

      @foreach($settings as $setting)
        <form class="form-inline" action="{{ route('settings.update',['id' => $setting->id]) }}" method="post">
          {{ csrf_field() }}
          <div class="form-group" style="margin:10px;">
            <label>Setting Name</label>
            <input style="width:200px;" type="text" value="{{ $setting->name }}" name="name" class="form-control" placeholder="Enter The Setting name" required autocomplete="off">
          </div>

          <div class="form-group">
              <label>Setting Value</label>
              <input style="width:200px;" type="text" value="{{ $setting->value }}" name="value" class="form-control" placeholder="Enter The Setting Value" required autocomplete="off">
            </div>

          <div class="form-group">
              <button style="margin-top:1px;" type="submit" name="submit" class="btn btn-default bg-purple"><i class="fa fa-save"></i> Save Changes</button>
              <a href="{{ route('settings.destroy',['id' => $setting->id]) }}" onclick="return confirm('Are You Sure ?')" class="btn btn-default"> <i class="fa fa-trash"></i></a>
          </div>  
        </form>
      @endforeach
    </div>
  </div>
</div>
@stop




@section('css')
  <style media="screen">
       body{font-family: Segoe UI;}
      .content-wrapper {background-color: white;}
  </style>
@stop

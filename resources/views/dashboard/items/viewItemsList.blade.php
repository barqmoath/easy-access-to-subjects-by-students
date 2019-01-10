@extends('adminlte::page')

@section('title', 'EASS Items')

@section('content_header')
@include('includes.parts.msg')
@include('includes.parts.err')


<center>
  <h1 style="font-weight:700;font-size:45px;"> Find {{ count($items) }} items</h1>
  <h3 style="margin-top: 5px;" class="text-center"><i class="fa fa-tags"></i> {{ $subject->subject_name }}</h3>
  <a href="{{ route('subjects.view_subject',['slug' => $subject->slug]) }}" class="btn btn-default btn-sm bg-purple" style="width: 185px;">BACK TO SUBJECT</a>
  <a href="{{ route('subjects.start') }}" class="btn btn-default btn-sm bg-purple" style="width: 185px;">BROWSE</a>
  <a href="" class="btn btn-default btn-sm bg-purple" style="width: 185px;">REFRESH</a>
  <a href="{{ route('items.upload_edit_view',['view' => 'upload', 'dept' => $subject->department_id, 'stg' => $subject->stage_id, 'sub' => $subject->id]) }}" class="btn btn-default btn-sm bg-purple" style="width: 185px;">UPLOAD</a>
</center>



<hr>
@stop

@section('content')
<div class="content">
  <div class="items-show-screen">
    @if(count($items) > 0)
      @foreach($items as $item)
        <style media="screen">
          .box-primary {
            border-left: 3px solid #605ca8;
            border-top:0px solid #EEE;
            border-radius: 0px;
            transition: .3s;
          }
          .box-primary {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
          }
        </style>
        <div class="box box-primary">
          <div class="box-header" style="border-bottom: 1px solid #EEE;">
            <div class="row">
              <div class="col-md-8"><span style="font-size:15px; font-weight:500;">{{ $item->itemtitle }} <i class="fa fa-arrow-right"></i> {{ $item->subjectname }}</span></div>
              <div class="col-md-4"><div style="float:right;"> {{ $item->departmentname }} <i class="fa fa-slack"></i> {{ $item->stagename }} </div></div>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12 text-center">
                <div style="background-color: #EEE; border-radius: 12px; padding: 10px;">
                  <p>{{ $item->itemdiscription }}</p>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer">
            <div class="btn-group">
              <a target="_blank" rel="noopener noreferrer" href="{{ Request::root() }}/data/items/files/{{ $item->itemfile }}" class="btn btn-default btn-flat btn-sm" style="width:200px;"><i class="fa fa-download"></i> Download .. Print .. etc..</a>
              <a target="_blank" rel="noopener noreferrer" href="{{ route('browse.item_view',['id' => $item->itemid]) }}" class="btn btn-default btn-flat btn-sm" style="width:100px;"><i class="fa fa-eye"></i> Display</a>
              @if($item->userid === Auth::user()->id)
                <a href="{{ route('items.upload_edit_view',['showState' => 'edit', 'item' => $item->itemid, 'uid' => $item->userid]) }}" class="btn btn-default btn-flat btn-sm" style="width:75px;"><i class="fa fa-edit"></i> Edit</a>
              @endif
              <a href="{{ route('items.delete', ['id' => $item->itemid, 'fl' => $item->itemfile]) }}" onclick="return confirm('Are you sure you delete this item ? Can not restore any data after the deletions . Take care of your triggeration in such operations .')" class="btn btn-default btn-flat btn-sm" style="width:75px;"><i class="fa fa-remove"></i> Delete</a>
            </div>
            <div style="float:right;padding:4px;">
              <i class="fa fa-user"></i> {{ $item->username }} |
              <i class="fa fa-calendar-o"></i> {{ $item->itemyear }} |
              <i class="fa fa-tag"></i> {{ $item->categoryname }} |
              <i class="fa fa-clock-o"></i> <span>{{ \Carbon\Carbon::parse($item->itemuploaddate)->timezone('Asia/Baghdad')->format('d F Y, h:i A')}}</span>

            </div>
          </div>
        </div>
      @endforeach
      {{ $items->links() }}
    @else
     <center>
       <h2>NO ITEMS <i class="fa fa-smile-o"></i></h2>
     </center>
    @endif
  </div>
</div>
@stop




@section('css')
<style media="screen">
  /* body{font-family: Segoe UI;} */
  .content-wrapper {background-color: white;}
</style>
@stop

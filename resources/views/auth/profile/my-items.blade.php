@extends('layouts.app')
@section('title','My Items')


@section('content')
<div class="container">
  @include('includes.parts.msg')
  @include('includes.parts.err')
</div>

<div class="container">
  <div class="row">
    <div class="col-md-9">
      <h1 style="margin:6px;font-size:3.5rem;">You Have {{ $itemscounter }} Item</h1>
      <h6 style="margin-left:13px;color:#6c757d;">These are all the elements that you have uploaded or posted</h6>
    </div>
    <div class="col-md-3">
      <a href="{{ route('upload.upload_in_my_stage') }}" class="btn btn-danger" style="margin-top:15px;width:100%;text-transform: inherit;font-size: 1.2rem;">Upload Page</a>
    </div>
  </div>
  <hr>
</div>

<div class="container" style="min-height:79.5vh;margin-top:30px;">
  <div class="row">
    <div class="col-md-12">
      @forelse($items as $item)
      <!--Card-->
        <div class="card" style="margin:10px;">
          <!--Card content-->
          <div class="card-body text-center">
            <!--Title-->
            <h4 style="font-size:2.4rem;" class="card-title">{{ $item->itemtitle }}</h4>
            <h3 style="font-size:1.2rem;">{{ $item->departmentname }} <i class="fa fa-arrow-right"></i> {{ $item->stagename }} <i class="fa fa-arrow-right"></i> {{ $item->subjectname }} </h3>
            <!--Text-->
            <p style="color: #000;font-size:1.3rem;background-color:#dee2e6;border-radius:0.25rem;padding:13px;" class="card-text">{{ $item->itemdiscription }}</p>
            <!-- Actions -->
            <div class="text-center">
              <a href="{{ route('browse.item_view',['id' => $item->itemid]) }}" target="_blank" class="btn btn-primary btn-sm" style="font-size:1rem;width:130px!important;">Dispaly</a>
              <a href="{{ Request::root() }}/data/items/files/{{ $item->itemfile }}" target="_blank" class="btn btn-primary btn-sm" style="font-size:1rem;width:130px!important;">Download</a>
              <div class="row">
                <div class="col-md-6 text-left">
                  <h3 style="font-size:1rem; margin:8px;color:#607D8B;"> <i class="fa fa-user-o"></i> {{ $item->username }} - <i class="fa fa-calendar-o"></i> {{ $item->itemyear }} - <i class="fa fa-tag"></i> {{ $item->categoryname }}</h3>
                </div>
                <div class="col-md-6 text-right">
                  <h3 style="font-size:1rem; margin:8px;color:#607D8B;"><i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($item->itemuploaddate)->timezone('Asia/Baghdad')->format('d F Y, h:i A')}} </h3>
                </div>
              </div>
              <!-- //////////////////// Item Control ////////////// -->
              <center>
                @if(Auth::user()->role === 'Owner' || Auth::user()->id === $item->userid)
                  <a href="{{ route('item.delete',['id' => $item->itemid, 'file' => $item->itemfile]) }}" onclick="return confirm('Are You Sure .. Any Data Can Not Be Retrieved After This Process !')" class="" style="font-size:1.4rem;float:right;margin:3px;"> <i class="fa fa-trash"></i> </a>
                @endif
                @if(Auth::user()->id === $item->userid)
                  <a href="{{ route('item.item_edit_show',['id' => $item->itemid]) }}" style="font-size:1.4rem;float:right;margin:3px;margin-top:4px;"> <i class="fa fa-edit"></i> </a>
                @endif
              </center>
              <!-- //////////////////// Item Control ////////////// -->
            </div>
          </div>
        </div>
      @empty
        <center>
          <h1 style="font-size:4rem;font-weight:400;margin:30px;">Empty <i class="fa fa-smile-o"></i> </h1>
        </center>
      @endforelse
      <!-- Pagnation -->
      <div class="row">
        <div class="col-md-12">
          <center>
            {{ $items->links('includes.Pagination.Pagination') }}
          </center>
        </div>
      </div>
    </div>
  </div>

</div>

@stop

@section('css')
<style media="screen">
.btn-primary {
  width: 200px;
  background-color:#3f51b5!important;
  font-size:1rem!important;
  text-transform: initial;
}
.btn-primary:hover{
  background-color: #234988 !important;
}
</style>
@stop

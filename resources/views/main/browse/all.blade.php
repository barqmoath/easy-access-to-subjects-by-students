@extends('layouts.app')
@section('title','For You')

@section('content')
<div class="container">
  @include('includes.parts.msg')
  @include('includes.parts.err')

  <h1 style="margin-left:13px;margin-top:10px;margin-bottom:15px;font-size:4.2rem;">For You</h1>
</div>


<div class="container" style="min-height:76vh;">
  <div class="row">
    <div class="col-md-12">
      @forelse($items as $item)
      <!--Card-->
        <div class="card" style="margin:10px;border-radius:5px;">
          <!--Card content-->
          <div class="card-body text-center">
            <!--Title-->
            <div class="row">
              <div class="col-md-6 text-left">
                <h4 style="font-size:1.4rem;" class="card-title">{{ $item->itemtitle }} <i class="fa fa-arrow-right"></i> {{ $item->subjectname }}  </h4>
              </div>
              <div class="col-md-6 text-right">
                <h3 style="font-size:1.2rem;">{{ $item->departmentname }} <i class="fa fa-arrow-right"></i> {{ $item->stagename }}</h3>
              </div>
            </div>
            <!--Text-->
            <p style="color: #000;font-size:1.3rem;background-color:#dee2e6;border-radius:0.25rem;padding:13px;" class="card-text">{{ $item->itemdiscription }}</p>
            <!-- Actions -->
            <div class="text-center">
              <a href="{{ route('browse.item_view',['id' => $item->itemid]) }}" target="_blank" class="btn btn-primary btn-sm" style="font-size:1rem;width:130px!important;">Dispaly</a>
              @if(!empty($item->itemfile))
                <a href="{{ Request::root() }}/data/items/files/{{ $item->itemfile }}" target="_blank" class="btn btn-primary btn-sm" style="font-size:1rem;width:130px!important;">Download</a>
              @endif
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
                  <a target="_blank" href="{{ route('item.item_edit_show',['id' => $item->itemid]) }}" style="font-size:1.4rem;float:right;margin:3px;margin-top:4px;"> <i class="fa fa-edit"></i> </a>
                @endif
              </center>
              <!-- //////////////////// Item Control ////////////// -->
            </div>
          </div>
        </div>
      @empty
      <center>
        <h1 style="font-size:6.3rem;font-weight:100;margin-top:40px;">NO ITEMS <i class="fa fa-frown-o"></i> </h1>
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

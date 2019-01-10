@extends('layouts.app')
@section('title','Search in EASS')


@section('content')
<div class="container">
  @include('includes.parts.msg')
  @include('includes.parts.err')
</div>

<div class="container" style="min-height:75.6vh;">
  <!-- Search Input -->
  @php
    $oldTxt = '';
    $actv = '';
    if(isset($_GET['txt']))
    {
      $oldTxt = $_GET['txt'];
      $actv = "active";
    }
  @endphp
  <div class="search {{ $actv }}">
    <form class="" action="{{ route('search.search') }}" method="get">
      <input type="text" name="txt" placeholder="Type it here ..." autocomplete="off" value="{{ $oldTxt }}">
    </form>
    <div class="icon"></div>
  </div>
  @if(!isset($results))
  <center>
    <h1 style="margin-top:120px;font-size:5rem;font-weight:100;">What are you looking for ?</h1>
    <p style="color: #607D8B;font-size:1.4rem;">Her you can find here anything in your current stage .. Click on the Search button at the top and start </p>
    <!-- <img src="{{ Request::root() }}/vendor/main/img/search-01.png" alt="Search" width="250" height="250" style="margin:0px;padding:.25rem;"> -->
    <div class="loader">Search ...</div>
  </center>
  @else
    @if(count($results) > 0)
      <center>
        <h1 style="margin-top:120px;margin-bottom: 20px;font-size:3.5rem;font-weight:100;"> <i class="fa fa-search"></i> These Results Were Found</h1>
      </center>
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
          @foreach($results as $item)
            <!--Card-->
              <div class="card" style="margin:10px;">
                <!--Card content-->
                <div class="card-body text-center">
                  <!--Title-->
                  <h4 style="font-size:2.4rem;" class="card-title">{{ $item->itemtitle }}</h4>
                  <h3 style="font-size:1.2rem;">{{ $item->departmentname }} <i class="fa fa-arrow-right"></i> {{ $item->stagename }} <i class="fa fa-arrow-right"></i> {{ $item->subjectname }} </h3>
                  <!--Text-->
                  <p style="color: #000;font-size:1.2rem;background-color:#CCC;border-radius:0.25rem;padding:13px;" class="card-text">{{ $item->itemdiscription }}</p>
                  <!-- Actions -->
                  <div class="text-center">
                    <a href="{{ route('browse.item_view',['id' => $item->itemid]) }}" target="_blank" class="btn btn-primary btn-sm" style="font-size:1rem;width:130px!important;">Dispaly</a>
                    <a href="{{ Request::root() }}/data/items/files/{{ $item->itemfile }}" target="_blank" class="btn btn-primary btn-sm" style="font-size:1rem;width:130px!important;">Download</a>
                    <div class="row">
                      <div class="col-md-6 text-left">
                        <h3 style="font-size:1rem; margin:8px;color:#607D8B;"> <i class="fa fa-user-o"></i> {{ $item->username }} - <i class="fa fa-calendar-o"></i> {{ $item->itemyear }} - <i class="fa fa-tag"></i> {{ $item->categoryname }}</h3>
                      </div>
                      <div class="col-md-6 text-right">
                        <h3 style="font-size:1rem; margin:8px;color:#607D8B;"><i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($item->itemuploaddate)->format('d F Y, h:i A')}} </h3>
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
          @endforeach
          <!-- Pagnation -->
          <div class="row">
            <div class="col-md-12">
              <center>
                {{ $results->links('includes.Pagination.Pagination') }}
              </center>
            </div>
          </div>
        </div>
        <div class="col-md-1"></div>
      </div>
    @else
      <center>
        <h1 style="margin-top:120px;font-size:5rem;font-weight:100;">No Results <i class="fa fa-meh-o"></i> </h1>
        <div class="loader">Search ...</div>
      </center>
    @endif
  @endif
</div>

@stop

@section('js')
<script type="text/javascript">
$(document).ready(function(){
  $('.icon').click(function(){
    $('.search').toggleClass('active');
});
});
</script>
@stop

@section('css')
<style media="screen">
.search {
    position:absolute;
    top:20%;
    left:50%;
    transform:translate(-50%,-50%);
    width:80px;
    height:80px;
    background:#fff;
    box-shadow:0 5px 20px rgba(0,0,0,.5);
    border-radius:4px;
    transition:width .5s;
    overflow:hidden;
}
.search.active {
    width:600px;
}
.search input {
    position:absolute;
    top:10px;
    left:10px;
    width:calc(100% - 90px);
    height:60px;
    border:none;
    outline:none;
    font-size:36px;
    padding:0 10px;
    color:#666;

}
.search.active .icon {
    background:#ff355a;
}
.icon {
    position:absolute;
    top:10px;
    right:10px;
    width:60px;
    height:60px;
    cursor:pointer;
    transition:.5s;
    border-radius:4px;
}
.search.active .icon:before {
    content:'';
    position:absolute;
    top:7px;
    left:13px;
    width:18px;
    height:30px;
    background:transparent;
    border:none;
    border-right:2px solid #fff;
    border-radius:0;
    transition:.5%;
    transform:rotate(45deg);
}
.search.active .icon:after {
    content:'';
    position:absolute;
    top:20px;
    left:13px;
    width:18px;
    height:30px;
    background:transparent;
    border:none;
    border-right:2px solid #fff;
    border-radius:0;
    transition:.5%;
    transform:rotate(-45deg);
}
.icon:before {
    content:'';
    position:absolute;
    top:12px;
    left:12px;
    width:24px;
    height:24px;
    background:transparent;
    border:2px solid #262626;
    border-radius:50%;
    transition:.5%;
}
.icon:after {
    content:'';
    position:absolute;
    top:25px;
    left:35px;
    width:18px;
    height:18px;
    background:transparent;
    border-left:2px solid #262626;
    border-radius:0;
    transform:rotate(-45deg);
    transition:.5%;
}


.loader {
  overflow: hidden;
  font-size: 10px;
  margin: 50px auto;
  text-indent: -9999em;
  width: 11em;
  height: 11em;
  border-radius: 50%;
  background: #FFF;
  background: linear-gradient(to right, #343a40 10%, rgba(255, 255, 255, 0) 42%);
  position: relative;
  animation: load3 1.4s infinite linear;
  transform: translateZ(0);
}
  .loader:before {
    width: 50%;
    height: 50%;
    background: #343a40;
    border-radius: 100% 0 0 0;
    position: absolute;
    top: 0;
    left: 0;
    content: '';
  }

  .loader:after {
    background: #FFF;
    width: 75%;
    height: 75%;
    border-radius: 50%;
    content: '';
    margin: auto;
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    opacity: 0.5;
  }
}

@-webkit-keyframes load3 {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

@keyframes load3 {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}


</style>
@stop

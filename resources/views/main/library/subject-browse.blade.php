@extends('layouts.app')
@section('title')
  {{ $subject->subjectname }}
@stop

@section('content')
<div class="container">
  @include('includes.parts.msg')
  @include('includes.parts.err')
</div>

<!-- Heading Container -->
<div class="container">
  <div class="main-title">
    <div class="row">
      <div class="col-md-6 text-center">
        <h5 style="margin-top:11px;"> <i class="fa fa-map-marker"></i> {{ $subject->departmentname }} <i class="fa fa-chevron-right"></i> {{ $subject->stagename }}</h5>
      </div>
      <div class="col-md-6 text-center">
        <div class="btn-group">

          <!-- Categories Dropdown -->
          <div class="dropdown" style="margin:5px;">
              <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-info btn-sm" data-target="#" href="#" style="">
                  Categories <span class="caret"></span>
              </a>
              <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu" style="min-width:50%;">
                <a class="dropdown-item" tabindex="-1" href="{{ route('library.sub',['subject_slug' => $subject->subjectslug, 'depID' => $subject->departmentid, 'stgID' => $subject->stageid]) }}">All</a>
                @foreach($categories as $cat)
                <li class="dropdown-submenu ">
                  <a class="dropdown-item" tabindex="-1" href="{{ route('library.sub',['subject_slug' => $subject->subjectslug, 'depID' => $subject->departmentid, 'stgID' => $subject->stageid, 'cat' => $cat->slug]) }}">{{ $cat->category_name }}</a>
                  <ul class="dropdown-menu">
                    @foreach($years as $year)
                      <li><a class="dropdown-item" tabindex="-1" href="{{ route('library.sub',['subject_slug' => $subject->subjectslug, 'depID' => $subject->departmentid, 'stgID' => $subject->stageid, 'cat' => $cat->slug, 'year' => $year->the_year]) }}"><i class="fa fa-calendar-o"></i> {{ $year->the_year }}</a></li>
                    @endforeach
                  </ul>
                </li>
                @endforeach
                <li class="dropdown-divider"></li>
                <li class="dropdown-submenu ">
                  <a class="dropdown-item" tabindex="-1" href="{{ route('library.sub',['subject_slug' => $subject->subjectslug, 'depID' => $subject->departmentid, 'stgID' => $subject->stageid, 'cat' => $cat->slug]) }}">By Year Only</a>
                  <ul class="dropdown-menu">
                    @foreach($years as $year)
                      <li><a class="dropdown-item" tabindex="-1" href="{{ route('library.sub',['subject_slug' => $subject->subjectslug, 'depID' => $subject->departmentid, 'stgID' => $subject->stageid, 'year' => $year->the_year]) }}"><i class="fa fa-calendar-o"></i> {{ $year->the_year }}</a></li>
                    @endforeach
                  </ul>
                </li>
              </ul>
          </div>
          <!-- Subjects Dropdown -->
          <div class="dropdown" style="margin:5px;">
              <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-info btn-sm" data-target="#" href="#" style="">
                  Other Subjects <span class="caret"></span>
              </a>
              <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu" style="min-width:50%;">
                @foreach($subjects as $sub)
                  <li><a class="dropdown-item" tabindex="-1" href="{{ route('library.sub',['subject_slug' => $sub->slug, 'depID' => $sub->department_id, 'stgID' => $sub->stage_id]) }}">{{ $sub->subject_name }}</a></li>
                @endforeach
              </ul>
          </div>



        </div>
      </div>
    </div>
  </div>
</div>





<!-- Items Display Container -->
<div class="container" style="min-height:100vh;">
  <h2 style="font-size:3rem;font-weight:700;margin-top:20px;margin-left:10px;margin-bottom:30px;">{{ $itemscounter }} Items About <span style="font-size:3rem;font-weight:700;color:#3f51b5;">{{ $subject->subjectname }}</span></h2>
  <hr>
  <!-- Search And Status Row -->
  <div class="row">
    <div class="col-sm-6">
      <p style="display: inline-block;font-size:1.2rem;font-weight:700;margin:13px;">{{ $text }}</p>
    </div>
    <div class="col-sm-6">
      <form class="" action="{{ route('library.sub',['subject_slug' => $subject->subjectslug, 'depID' => $subject->departmentid, 'stgID' => $subject->stageid]) }}" method="get">
        <!-- Material input -->
        <div class="md-form">
            @php
              $oldText = '';
              if(isset($_GET['searchQuery']) && !empty($_GET['searchQuery']))
                $oldText = $_GET['searchQuery'];
            @endphp
            <input type="text" value="{{ $oldText }}" name="searchQuery" id="searchQuery" class="form-control" autocomplete="off" required>
            <label for="form1" > <i class="fa fa-search"></i> Search ...</label>
        </div>
      </form>
    </div>
  </div>

  <!-- Items Display Row -->
  <div class="row">
    @forelse($items as $item)
      <div class="col-md-12">
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
      </div>
    @empty
    <div class="col-md-12">
      <center> <h2>There Is Nothing Here <i class="fa fa-meh-o"></i> </h2> </center>
    </div>
    @endforelse
  </div>
</div>

@stop


@section('js')
<script type="text/javascript">
$(document).ready(function(){

    //When it is written in " #searchText " Input
    $("#searchText").on('input',function(e){
      //alert('Changed!')

    });



});
</script>
@stop



@section('css')
<style media="screen">

/* Dropdown Multi Level Style Start */

.btn-primary {
  width: 200px;
  background-color:#3f51b5!important;
  font-size:1rem!important;
  text-transform: initial;
}
.btn-primary:hover{
  background-color: #234988 !important;
}

.btn-info {
  background-color: #343a40!important;
  color: #fff!important;
  text-transform: initial;
  font-size: 1rem !important;
  width: 200px;
}
.btn-info:hover {
  background-color: #333!important;
}

.dropdown-menu {
  box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
  border-radius: 0px;
  border-top: 2px solid #222;
}
.dropdown-item:focus, .dropdown-item:hover {
    color: #dee2e6;
    text-decoration: none;
    background-color: #343a40;
}

.dropdown-submenu {
    position: relative;
}

.dropdown-submenu>.dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -6px;
    margin-left: -1px;
    -webkit-border-radius: 0 6px 6px 6px;
    -moz-border-radius: 0 6px 6px;
    border-radius: 0px;
}

.dropdown-submenu:hover>.dropdown-menu {
    display: block;
}

.dropdown-submenu>a:after {
    display: block;
    content: " ";
    float: right;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
    border-width: 5px 0 5px 5px;
    border-left-color: #ccc;
    margin-top: 5px;
    margin-right: -10px;
}

.dropdown-submenu:hover>a:after {
    border-left-color: #fff;
}

.dropdown-submenu.pull-left {
    float: none;
}

.dropdown-submenu.pull-left>.dropdown-menu {
    left: -100%;
    margin-left: 10px;
    -webkit-border-radius: 6px 0 6px 6px;
    -moz-border-radius: 6px 0 6px 6px;
    border-radius: 6px 0 6px 6px;
}
/* Dropdown Multi Level Style End */

.main-title {
  margin: 5px;
  padding: 10px;
  background-color: #EEE;
  border: 1px solid #FAFAFA;
  border-radius: .5rem;
  display: block;
}


.md-form {
    position: relative;
    margin-right: 10px;
    margin-top: 0rem;
    margin-bottom: 0rem;
    float: right;
    width: 35%;
}

</style>
@stop

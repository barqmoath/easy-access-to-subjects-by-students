@extends('layouts.app')
@section('title')
{{ $subject->subject_name }} Browse
@stop

@section('content')
<div class="container">
  @include('includes.parts.msg')
  @include('includes.parts.err')
</div>

<div class="container">
  <p style="font-size:2.5rem;font-weight:700;margin-left:10px;margin-top:10px;">Everything related to  <span style="font-size:2.5rem;font-weight:700;color:#3f51b5;">{{ $subject->subject_name }}</span> <br> </p>
  <div class="row">
    <div class="col-sm-8 text-left">
      <h1 style="margin-top:11px;margin-left:10px;font-size:1.2rem;font-weight:400;">{{ $text }}</h1>
    </div>
    <div class="col-sm-4 text-right">
      <form action="{{ route('browse.index',['slug' => $subject->slug]) }}" method="get">
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
</div>

<div class="container" style="min-height: 88.5vh;margin-top:10px;">
  <hr>

  <div class="row">
    <div class="col-md-3">

      <!-- Category Section -->
      <div class="categories">
        <h1 style="margin:5px;margin-bottom: 10px;font-size:1.2rem;font-weight:400;">Categories</h1>
        <div class="list-group">
          <a href="{{ route('browse.index',['slug' => $subject->slug]) }}" class="list-group-item  waves-light">All In This Year</a>
          @foreach($categories as $cat)
            <a href="{{ route('browse.index',['slug' => $subject->slug, 'cat' => $cat->slug]) }}" class="list-group-item  waves-light">{{ $cat->category_name }}</a>
          @endforeach
        </div>
        <hr>

        <!--Years Section -->
        <h1 style="margin:5px;margin-bottom: 10px;font-size:1.2rem;font-weight:400;"> Years</h1>
        <div class="btn-group-vertical" role="group" aria-label="Vertical button group" style="width:100%;">
          <div class="btn-group" role="group">
              <button id="btnGroupVerticalDrop4" type="button" class="btn btn-indigo dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 1rem;text-transform: inherit;text-align: left;border-radius:0px;padding: 1.25rem 1.25rem;">
                  Years
              </button>
              <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop4">
                @foreach($years as $year)
                  <a class="dropdown-item" href="{{ route('browse.index',['slug' => $subject->slug, 'year' => $year->the_year]) }}">{{ $year->the_year }}</a>
                @endforeach
              </div>
          </div>
        </div>
        <hr>

        <!-- Category & Years Section -->
        <h1 style="margin:5px;margin-bottom: 10px;font-size:1.2rem;font-weight:400;">Category & Year</h1>
        @foreach($categories as $cat)
          <div class="btn-group-vertical" role="group" aria-label="Vertical button group" style="width:100%;">
            <div class="btn-group" role="group">
                <button id="btnGroupVerticalDrop4" type="button" class="btn btn-indigo dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 1rem;text-transform: inherit;text-align: left;border-radius:0px;padding: 1.25rem 1.25rem;">
                    {{ $cat->category_name }}
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop4">
                  @foreach($years as $year)
                    <a class="dropdown-item" href="{{ route('browse.index',['slug' => $subject->slug, 'cat' => $cat->slug, 'year' => $year->the_year]) }}">{{ $year->the_year }}</a>
                  @endforeach
                </div>
            </div>
          </div>
        @endforeach
        <hr>

        <!-- More Subjects Section -->
        <h1 style="margin:5px;margin-bottom: 10px;font-size:1.2rem;font-weight:400;">Other Subjects</h1>
        <div class="list-group">
          @foreach($subjects as $sub)
            <a href="{{ route('browse.index',['slug' => $sub->slug]) }}" class="list-group-item  waves-light">{{ $sub->subject_name }}</a>
          @endforeach
        </div>
      </div>
    </div>

    <div class="col-md-9">

      @forelse($items as $item)
      <!--Card-->
        <div class="card" style="margin:10px;border-radius:5px;">
          <!--Card content-->
          <div class="card-body text-center">
            <!--Title-->
            <h4 style="font-size:1.7rem;font-weight:700;" class="card-title">{{ $item->itemtitle }}</h4>
            <h3 style="font-size:1.2rem;">{{ $item->departmentname }} <i class="fa fa-arrow-right"></i> {{ $item->stagename }} <i class="fa fa-arrow-right"></i> {{ $item->subjectname }} </h3>
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

.categories {
  margin-top: 10px;
}
.btn-indigo.dropdown-toggle {
  background-color: #2a394f!important;
}

.list-group-item {
    padding: 1.25rem 1.25rem;
    background-color: #2a394f;
    border-radius: 0px;
    color: #EEE;
    font-size:1rem;
    list-style: none;
}
.list-group-item:hover {
  background-color: #4D5EC1;
  color: white;
}

.list-group .list-group-item:last-child {
  -webkit-border-bottom-left-radius: 0rem;
  border-bottom-left-radius: .0rem;
  -webkit-border-bottom-right-radius: 0rem;
  border-bottom-right-radius: 0rem;
}

.list-group .list-group-item:first-child {
  -webkit-border-bottom-left-radius: 0rem;
  border-bottom-left-radius: .0rem;
  -webkit-border-bottom-right-radius: 0rem;
  border-bottom-right-radius: 0rem;
}

.dropdown-menu {
  border-radius: 0px;
  border-top: 2px solid #252f69;
  box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
}

.dropdown-item:hover {
  color: #EEE;
  background-color: #252f69;
  padding-left: 1.8rem;
}

.md-form {
    position: relative;
    margin-top: 0rem;
    margin-bottom: 0rem;
    width: 70%;
    float: right;
}

</style>
@stop

@extends('layouts.app')
@section('title')
  {{ Auth::user()->name }} - Bag
@stop

@section('content')

<div class="container">
  <div class="">
    <div class="row">
      <div class="col-md-12 text-center">

        <!-- Years dropdown -->
        <div class="btn-group" style="padding:7px;">
            <button style="" class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sort By Year</button>
            <div class="dropdown-menu" style="min-width:295px;">
              @foreach($years as $yr)
                <a class="dropdown-item" href="{{ route('bag.index',['year' => $yr->the_year]) }}">{{ $yr->the_year }}</a>
              @endforeach
            </div>
        </div>

        <!-- Category dropdown -->
        <div class="btn-group" style="padding:7px;">
            <button style="" class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sort By Category</button>
            <div class="dropdown-menu" style="min-width:295px;">
              <a class="dropdown-item" href="{{ route('bag.index') }}">All</a>
              @foreach($categories as $cat)
                <a class="dropdown-item" href="{{ route('bag.index',['cat' => $cat->slug]) }}">{{ $cat->category_name }}</a>
              @endforeach
            </div>
        </div>

        <!-- Category dropdown -->
        <div class="btn-group" style="padding:7px;">
            <button style="" class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sort By Subject</button>
            <div class="dropdown-menu" style="min-width:295px;">
              @foreach($subjects as $sub)
                <a class="dropdown-item" href="{{ route('bag.index',['sub' => $sub->slug]) }}">{{ $sub->subject_name }}</a>
              @endforeach
            </div>
        </div>

        <a href="{{ route('bag.empty') }}" onclick="return confirm('This process will empty your bag of all contents . and can not be retreating after that ... Do you really want continue ? ')" class="btn btn-primary btn-sm ">Empty The Bag</a>
        <a href="{{ route('bag.index') }}" class="btn btn-primary btn-sm ">Refresh</a>

      </div>
    </div>
  </div>
</div>

<div class="container">
  @include('includes.parts.msg')
  <div class="row">
    <!--<img class="img-thumbnail" style="border:0px;border-radius:1rem;margin-top:50px;" width="200" height="200" src="{{ Request::root() }}/data/users/photos/{{ Auth::user()->photo }}" alt="User Photo">-->
    <div class="col-md-12">
      <h1 style="font-size:7rem;font-weight:100;margin-left:14px;">My Bag</h1>
    </div>
  </div>
  <br>
</div>


<div class="container" style="min-height: 88.5vh;">
  <div class="divider-new mt-0 mb-4">
    <h2 style="font-size:2rem!important;font-weight:100;" class="h3-responsive"> {{ count($items) }} ITEMS</h2>
  </div>

  <div class="row">
    @if(count($items) > 0)
    @foreach($items as $item)
      <div class="col-lg-6 col-md-12 mb-4">
        <!--Card-->
        <div class="card">
          <!--Card content-->
          <div class="card-body text-center">
              <!--Title-->
              <h4 class="card-title">{{ $item->itemtitle }}</h4>
              <h3 style="font-size:0.9rem;">{{ $item->departmentname }} <i class="fa fa-arrow-right"></i> {{ $item->stagename }} <i class="fa fa-arrow-right"></i> {{ $item->subjectname }} </h3>
              <h3 style="font-size:0.9rem;"><i class="fa fa-calendar-o"></i> {{ $item->itemyear }} - <i class="fa fa-tag"></i> {{ $item->categoryname }} </h3>
              <!--Text-->
              <p class="card-text">{{ $item->itemdiscription }}</p>
              <!-- Actions -->
              <div class="text-center">
                <a href="{{ route('browse.item_view',['id' => $item->itemid]) }}" target="_blank" class="btn btn-primary btn-sm" style="font-size:1rem;width:130px!important;">Dispaly</a>
                <a href="{{ route('bag.item_delete',['id' => $item->itemid]) }}" onclick="return confirm('Are you sure to remove this item from your bag ?')" class="btn btn-primary btn-sm" style="font-size:1rem;width:130px!important;">Remove</a>
                <h3 style="font-size:1rem; margin:8px;color:green;"> <i class="fa fa-clock-o"></i> Added At : {{ Carbon\Carbon::parse($item->addeddate)->timezone('Asia/Baghdad')->format('d-m-Y') }}</h3>
              </div>
          </div>
        </div>
        <!--/.Card-->
      </div>
    @endforeach
    @else
      <div class="col-md-12">
        <h1 style="font-size:3rem;font-weight:100;margin-top:18px;text-align:center;">No Items <i class="fa fa-smile-o"></i> </h1>
      </div>
    @endif

  </div>
</div>

@stop

@section('css')
<style media="screen">


.btn-primary {
  width: 200px;
  background-color:#2175aa!important;
  font-size:1rem!important;
  text-transform: initial;
}

.btn-primary:hover {
  background-color: #3f51b5 !important;
}

.btn-primary.dropdown-toggle {
    background-color: #2175aa!important;
}
.btn-primary.dropdown-toggle:hover {
  background-color: #3f51b5 !important;
}

.dropdown-menu {
  border-radius: 0rem;
  border-top: 2px solid #2175aa;
  box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
}

.dropdown-item:hover {
  background-color: #2175aa;
  color:#EEE;
  padding-left: 30px;
}
</style>
@stop

@extends('layouts.app')
@section('title')
{{ $item->itemtitle }}
@stop

@section('content')
<!-- Messages and Errors -->
<div class="container">
  @include('includes.parts.msg')
  @include('includes.parts.err')
</div>



<div class="container" style="min-height: 80.6vh;">
  <div class="row">
    <!-- Item Display Col -->
    <div class="col-md-6">
      <!--Card-->
        <div class="card" style="margin-top:10px;margin-bottom:10px;">
          <!--Card content-->
          <div class="card-body text-center">
            <!--Title-->
            <h4 style="font-size:2.4rem;" class="card-title">{{ $item->itemtitle }}</h4>
            <h3 style="font-size:1.1rem;margin-top:10px;">{{ $item->departmentname }} <i class="fa fa-arrow-right"></i> {{ $item->stagename }} <i class="fa fa-arrow-right"></i> {{ $item->subjectname }} </h3>
            <!--Text-->
            <p style="color: #000;font-size:1.3rem;background-color:#dee2e6;border-radius:0.25rem;padding:13px;" class="card-text">{{ $item->itemdiscription }}</p>
            <!-- Actions -->
            <div class="text-center">
              @if(!empty($item->itemfile))
                <a href="{{ Request::root() }}/data/items/files/{{ $item->itemfile }}" target="_blank" class="btn btn-primary btn-sm" style="font-size:1rem;width:220px!important;">Download</a>
              @endif
              <div class="row">
                <div class="col-md-12 text-center">
                  <h3 style="font-size:1rem; margin:8px;color:#607D8B;"> <i class="fa fa-user-o"></i> {{ $item->username }} - <i class="fa fa-calendar-o"></i> {{ $item->itemyear }} - <i class="fa fa-tag"></i> {{ $item->categoryname }} - <i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($item->itemuploaddate)->timezone('Asia/Baghdad')->format('d F Y, h:i A')}}</h3>
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

        <!-- Love and Bags and Comments -->
        @php
          $love_counter = 0;
          foreach($likes as $like)
            if($like->item_id === $item->itemid)
              $love_counter ++;

          $user_love_state = "";
          foreach($likes as $like)
            if($like->item_id === $item->itemid && $like->user_id === Auth::user()->id)
              $user_love_state = "love-active";

          $user_bag_state = "";
          foreach($bags as $bag)
             if($bag->item_id === $item->itemid && $bag->user_id === Auth::user()->id)
                  $user_bag_state = "bag-active";
          if($user_bag_state === "bag-active")
            $bag_text = "In My Bag";
          else
            $bag_text = "Add To Bag";
        @endphp
        <div class="row text-center">
          <div class="col-sm-4">
            <!--Love Botton-->
            <div id="love" class="love {{ $user_love_state }}" item-id="{{ $item->itemid }}">
              <i class="fa fa-heart"></i> <span id="love_counter" style="font-size:1.5rem;">{{ $love_counter }}</span>
            </div>
          </div>

          <div class="col-sm-4">
            <div class="coments-count">
              <i class="fa fa-comments"></i> {{ count($comments) }}
            </div>
          </div>

          @if(!empty($item->itemfile) && $item->departmentid === Auth::user()->department_id && $item->stageid === Auth::user()->stage_id)
          <div class="col-sm-4">
            <!--Bag Botton-->
            <div id="bag" class="bag {{ $user_bag_state }}" item-id="{{ $item->itemid }}">
              <i class="fa fa-briefcase "></i> <span id="bag_text" style="font-size:1.5rem;">{{ $bag_text }}</span>
            </div>
          </div>
          @endif
        </div>

        <div class="row">
          <div class="col-sm-3 text-center">
            <img style="margin-top:35px;margin-left:15px;" src="{{ Request::root() }}/data/users/photos/{{ Auth::user()->photo }}" alt="User Photo">
          </div>
          <div class="col-sm-9">
            <form class="" action="{{ route('comments.add') }}" method="post">
              {{ csrf_field() }}
              <div class="md-form form-lg" style="margin-top: 2.8rem;">
                  <input type="hidden" name="item_id" value="{{ $item->itemid }}">
                  <input type="text" name="the_comment" class="form-control form-control-lg" autocomplete="off" required autofocus>
                  <label for="">Write Comment</label>
              </div>
            </form>
          </div>
        </div>

        <!-- Love and Bags and Comments End  -->
    </div>
    <!-- Comments Display Col -->
    <div class="col-md-6">
      <div class="slider-wrap">
        <div id="card-slider" class="slider">

          @if(count($comments) < 4)
            <div class="slider-item">
                <div class="animation-card_image">
                    <img src="{{ Request::root() }}/data/users/photos/default-user-photo.png" alt="">
                </div>
                <div class="animation-card_content">
                    <h4 class="animation-card_content_title title-2">EASS</h4>
                    <p class="animation-card_content_description p-2">Welcome to EASS, which is designed to serve you and facilitate your university education</p>
                    <p class="animation-card_content_city">EASS TEAM COMMENTS</p>
                </div>
            </div>

            <div class="slider-item">
                <div class="animation-card_image">
                    <img src="{{ Request::root() }}/data/users/photos/default-user-photo.png" alt="">
                </div>
                <div class="animation-card_content">
                    <h4 class="animation-card_content_title title-2">EASS</h4>
                    <p class="animation-card_content_description p-2">
                      We expect you to be all good because you are a college student
                      Do not make us attend or cancel your comments for misuse
                      <br>
                      نحن نتوقع منك كل جيد لانك طالب جامعي
                      فلا تجعلنا نقوم بحضرك او الغاء تعليقاتك بسبب سوء الاستخدام
                    </p>
                    <p class="animation-card_content_city"> EASS TEAM COMMENTS</p>
                </div>
            </div>

            <div class="slider-item">
                <div class="animation-card_image">
                    <img src="{{ Request::root() }}/data/users/photos/default-user-photo.png" alt="">
                </div>
                <div class="animation-card_content">
                    <h4 class="animation-card_content_title title-2">EASS</h4>
                    <p class="animation-card_content_description p-2">All comments and discussions will appear here</p>
                    <p class="animation-card_content_city">EASS TEAM COMMENTS</p>
                </div>
            </div>

            <div class="slider-item">
                <div class="animation-card_image">
                    <img src="{{ Request::root() }}/data/users/photos/default-user-photo.png" alt="">
                </div>
                <div class="animation-card_content">
                    <h4 class="animation-card_content_title title-2">EASS</h4>
                    <p class="animation-card_content_description p-2">You can directly study the article through the Download button</p>
                    <p class="animation-card_content_city">EASS TEAM COMMENTS</p>
                </div>
            </div>
          @endif
          @foreach($comments as $comment)
          <div class="slider-item">
              <div class="animation-card_image">
                  <img src="{{ Request::root() }}/data/users/photos/{{ $comment->userphoto }}" alt="User Photo">
              </div>
              <div class="animation-card_content">
                  <h4 class="animation-card_content_title title-2">{{ $comment->username }}</h4>
                  <p class="animation-card_content_description p-2">{{ $comment->comment }}</p>
                  <p class="animation-card_content_city"> <i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($comment->commentdatetime)->timezone('Asia/Baghdad')->format('d F Y, h:i A')}}</p>
              </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <hr>
  <div class="row">
    <div class="col-md-8">
      <h1 style="color:#6c757d;"> <i class="fa fa-comments-o"></i> Comments</h1>
      @forelse($comments as $comment)
      <div class="comment-box">
        <div class="c-header">
          <img src="{{ Request::root() }}/data/users/photos/{{ $comment->userphoto }}" alt="User Photo">
          <h3>{{ $comment->username }} - <i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($comment->commentdatetime)->timezone('Asia/Baghdad')->format('d F Y, h:i A')}}</h3>
        </div>
        <div class="c-content">
          <p style="font-size:1.3rem;">{{ $comment->comment }}</p>
        </div>
        <div class="c-footer text-right">
          @if(Auth::user()->role === 'Owner' || Auth::user()->role === 'Administrator' || Auth::user()->id === $comment->userid)
            @php $ui = Hash::make($comment->userid); @endphp
            <a href="{{ route('comments.delete',['cid' => $comment->commentid, 'ui' => $ui]) }}" onclick="return confirm('Are you sure ?')" style="font-size:1.4rem;float:right;margin:3px;margin-top:4px;"> <i class="fa fa-trash"></i> </a>
          @endif
        </div>
      </div>
      @empty
        <center>
          <h1 style="font-size:1.2rem;font-weight:100;">There are no comments yet <i class="fa fa-meh-o"></i></h1>
        </center>
      @endforelse
    </div>
    <div class="col-md-4">
      <h1 style="color:#6c757d;"> <i class="fa fa-heart-o"></i> Lovers</h1>
      <div class="row">
        @forelse($lovers as $love)
          <div class="col-sm-6 text-center">
            <div class="lv">
              <img class="lv-img" src="{{ Request::root() }}/data/users/photos/{{ $love->userphoto }}" alt="User Photo">
            </div>
          </div>
        @empty
        <center>
          <h1 style="font-size:1.2rem;font-weight:100;">Nobody love this item yet <i class="fa fa-meh-o"></i></h1>
        </center>
        @endforelse
      </div>
    </div>
  </div>
</div>
@stop





@section('js')
<script type="text/javascript" src="{{ Request::root() }}/vendor/main/js/TweenMax.min.js"></script>
<script type="text/javascript" src="{{ Request::root() }}/vendor/main/js/lb.js"></script>
<script type="text/javascript">

// This Varible For Love Button
var url        = "{{ route('love') }}",
    token      = "{{ Session::token() }}";

// This Varible For Bag Button
var burl        = "{{ route('bag') }}",
    btoken      = "{{ Session::token() }}";


// Comments Display Scripts
$(document).ready(function(){
  var cards = $('#card-slider .slider-item').toArray();
  startAnim(cards);
});

function startAnim(array){
    if(array.length >= 4 ) {
        TweenMax.fromTo(array[0], 0.5, {x:0, y: 0, opacity:0.75}, {x:0, y: -120, opacity:0, zIndex: 0, delay:0.03, ease: Cubic.easeInOut, onComplete: sortArray(array)});

        TweenMax.fromTo(array[1], 0.5, {x:79, y: 125, opacity:1, zIndex: 1}, {x:0, y: 0, opacity:0.75, zIndex: 0, boxShadow: '-5px 8px 8px 0 rgba(82,89,129,0.05)', ease: Cubic.easeInOut});

        TweenMax.to(array[2], 0.5, {bezier:[{x:0, y:250}, {x:65, y:200}, {x:79, y:125}], boxShadow: '-5px 8px 8px 0 rgba(82,89,129,0.05)', zIndex: 1, opacity: 1, ease: Cubic.easeInOut});

        TweenMax.fromTo(array[3], 0.5, {x:0, y:400, opacity: 0, zIndex: 0}, {x:0, y:250, opacity: 0.75, zIndex: 0, ease: Cubic.easeInOut}, );
    } else {
        $('#card-slider').append('<p>Sorry, carousel should contain more than 3 slides</p>')
    }
}

function sortArray(array) {
    clearTimeout(delay);
    var delay = setTimeout(function(){
        var firstElem = array.shift();
        array.push(firstElem);
        return startAnim(array);
    },5000)
}
</script>
@stop

@section('css')
<style media="screen">

.love,
.bag,
.coments-count {
  font-size: 1.5rem;
  color: #CCC;
  cursor: pointer;
  margin: 10px;
  transition: all .4s;
}

.bag-active {
  color: #162d38!important;
}

.love-active {
  color:#f44336!important;
}

.comment-box {
  background-color: #FAFAFA;
  border-radius: 10px;
  box-shadow: 0 4px 9px #f1f1f4;
  padding: 20px 0 25px 30px;
  margin:20px;
}

.comment-box .c-header {

}
.comment-box .c-header h3 {
  display: inline;
  font-size: 1.3rem;
  margin-left: 9px;
  color: #607D8B;
}
.comment-box .c-header a {
  font-weight:700;
  font-size:1.3rem;
}

.comment-box .c-content {
  text-align: center;
  padding: 5px;
  background-color: #FAFAFA;
  border-radius: 1rem;
}

.comment-box .c-footer{
  padding: 12px;
}

.lv {
  text-align: center;
  padding: 10px;
  margin: 2px;
}

.lv .lv-img {
  width: 120px;
  height: 120px;
  border: 2px solid #EEE;
  border-radius: 10px;
}


.slider-wrap{
  height: 100%;
  width: 100%;
}

.slider{
  position: absolute;
  width: 100%;
  left: 50px;
  top: 50px;
}

.slider-item{
  width: 450px;
  padding: 20px 0 25px 30px;
  border-radius: 10px;
  background-color: #ffffff;
  display: flex;
  justify-content: flex-start;
  position: absolute;
  opacity: 0;
  z-index: 0;
  box-shadow: 0 4px 9px #f1f1f4;
  position: absolute;
  left: 0;
  top: 0;
}

.animation-card_image{
  max-width: 60px;
  max-height: 60px;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 50%;
  box-shadow: 0 4px 9px rgba(241, 241, 244, 0.72);
  background-color: #ffffff;
}

img{
  width: 53px;
  height: 53px;
  border-radius: 50%;
  object-fit: cover;
}

.animation-card_content{
  width: 100%;
  max-width: 374px;
  margin-left: 26px;
  font-family: "Open Sans",sans-serif;
}

.animation-card_content_title{
  color: #4a4545;
  font-size: 16px;
  font-weight: 400;
  letter-spacing: -.18px;
  line-height: 24px;
  margin: 0;
}

.animation-card_content_description{
  color: #696d74;
  font-size: 15px;
  font-weight: 300;
  letter-spacing: normal;
  line-height: 24px;
  margin: 10px 0 0 0;
}

.animation-card_content_city{
  font-size: 11px;
  margin: 10px 0 0 0;
  font-size: 12px;
  font-weight: 500;
  text-transform: uppercase;
  color: #696d74;
}











</style>
@stop

@extends('layouts.app')
@section('title')
  {{ $user->name }}
@stop

@section('content')
<div class="container">
  <h2 style="font-size: 3rem; font-weight: 700; margin-bottom:20px;">{{ $user->name }} Profile</h2>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs nav-justified indigo" role="tablist">
      <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#p1" role="tab"><i class="fa fa-address-card"></i> Profile</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#p2" role="tab"><i class="fa fa-lock"></i> Password</a>
      </li>
  </ul>
  <!-- Include The Message File -->
  @include('includes.parts.msg')
  <!-- Include The Err File -->
  @include('includes.parts.err')
<!-- Tab panels -->
<div class="tab-content">

    <!--Panel 1-->
    <div class="tab-pane fade in show active" id="p1" role="tabpanel" style="min-height: 80vh;">
        <br>
          <form action="{{ route('profile.edit_profile') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-4">
                <center>
                  <h2 style="font-size: 1.8rem; font-weight: 100; margin-bottom:20px;"> <i class="fa fa-photo"></i> My Photo</h2>
                  <input type="password" name="oldphoto" value="{{ $user->photo }}" style="display:none;">
                  <img class="img-thumbnail" style="max-height: 260px; max-width: 260px;border:0px;border-radius:1rem;" src="{{ Request::root() }}/data/users/photos/{{ $user->photo }}" alt="My Photo">
                  <h6 style="margin:5px;">Chose Another Photo</h6>
                  <input type="file" name="photo" value="" style="padding: 0px 10px;">
                </center>
              </div>

              <div class="col-md-4">
                <center>
                  <h2 style="font-size: 1.8rem; font-weight: 100; margin-bottom:20px;"> <i class="fa fa-address-card-o"></i> My Info</h2>

                  <!-- Name input -->
                  <div class="form-group" style="text-align:left;">
                    <label>My Name</label>
                    <input value="{{ $user->name }}" name="name" type="text" class="form-control" autocomplete="off" required style="background-color: #EEE; border-radius: 0rem;">
                  </div>

                  <!-- Email input -->
                  <div class="form-group" style="text-align:left;">
                    <label>My Email</label>
                    <input type="password" name="oldemail" value="{{ $user->email }}" style="display:none;">
                    <input value="{{ $user->email }}" name="email" type="email" class="form-control" autocomplete="off" required style="background-color: #EEE; border-radius: 0rem;">
                  </div>

                  <!-- Facebook input -->
                  <div class="form-group" style="text-align:left;">
                    <label>My Facebook</label>
                    <input value="{{ $user->facebook_link }}" name="facebook_link" type="text" class="form-control" autocomplete="off" placeholder="Put Your Facebook Link Her" style="background-color: #EEE; border-radius: 0rem;">
                  </div>



                </center>
              </div>

              <div class="col-md-4">
                <center>
                  <h2 style="font-size: 1.8rem; font-weight: 100; margin-bottom:20px;"> <i class="fa fa-th"></i> My Stage</h2>
                  @if(count($ds) > 0)
                    <h5 style="margin-top:46px;font-size:1.1rem;color:#607d8b;"> <i class="fa fa-slack"></i> {{ $ds['department_name'] }}</h5>
                    <h5 style="font-size:1.1rem;color:#607d8b;"> <i class="fa fa-slack"></i> {{ $ds['stage_name'] }}</h5>
                    <input type="password" name="olddept" value="{{ $ds['department_id'] }}" style="display:none;">
                    <input type="password" name="oldstg" value="{{ $ds['stage_id'] }}" style="display:none;">
                  @else
                    <h5 style="margin-top:46px;font-size:1.1rem;color:#607d8b;"> - </h5>
                    <h5 style="font-size:1.1rem;color:#607d8b;"> - </h5>
                    <input type="password" name="olddept" value="none" style="display:none;">
                    <input type="password" name="oldstg" value="none" style="display:none;">
                  @endif

                  <div class="form-group" style="text-align:left;">
                    <label>Department</label>
                    <select class="form-control" name="department_id" id="dptSelect" style="background-color: #EEE; border-radius: 0rem;">
                      <option value="empty">Chose Department</option>
                      @foreach($departments as $dpt)
                        <option value="{{ $dpt->id }}">{{ $dpt->department_name }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group" style="text-align:left;">
                    <label>Stage</label>
                    <select class="form-control" name="stage_id" id="stgSelect" style="background-color: #EEE; border-radius: 0rem;">
                      <option dpt-id="none" value="empty">Chose Stage</option>
                      @foreach($stages as $stg)
                        <option dpt-id="{{ $stg->department_id }}" value="{{ $stg->id }}">{{ $stg->stage_name }}</option>
                      @endforeach
                    </select>
                  </div>


                </center>
              </div>

            </div>
            <center>
              <button class="btn btn-primary btn-sm" type="submit" name="submit" style="margin: 10px;background-color: #3f51b5 !important;font-size:0.9rem;width:250px;">Save Changes</button>
              <a href="{{ route('profile.delete') }}" class="btn btn-danger btn-sm" style="margin: 10px;font-size:0.9rem;width:250px;">Delete Account</a>
            </center>
          </form>
    </div>


    <!--Panel 2-->
    <div class="tab-pane fade" id="p2" role="tabpanel" style="min-height: 80vh;">
        <br>
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <center>
              <h2 style="font-size: 2rem; font-weight: 100; margin-bottom:20px;"> <i class="fa fa-lock"></i> Change My Password </h2>
            </center>

            <form class="" action="{{ route('profile.edit_password') }}" method="post">
              {{ csrf_field() }}

              <!-- old Password input -->
              <div class="md-form form-lg" style="margin-top: 2.8rem;">
                  <input type="password" name="old_password" class="form-control form-control-lg" autocomplete="new-password" required>
                  <label for="">Old Password</label>
              </div>

              <!-- new Password input -->
              <div class="md-form form-lg" style="margin-top: 2.8rem;">
                  <input type="password" name="password" class="form-control form-control-lg" autocomplete="new-password" required>
                  <label for="">New Password</label>
              </div>

              <!-- repeat Password input -->
              <div class="md-form form-lg" style="margin-top: 2.8rem;">
                  <input type="password" name="password_confirmation" class="form-control form-control-lg" autocomplete="new-password" required>
                  <label for="">Confirm New Password</label>
              </div>



              <center>
                <button type="submit" name="submit" class="btn btn-primary" style="background-color: #3f51b5!important; margin: 10px; width:200px;font-size:1rem;">Save Changes</button>
                <a href="#" class="btn btn-warning" style="margin: 10px; width:200px;font-size:1rem;">Forgot Password</a>
                <p> <i style="font-size:19px;" class="fa fa-smile-o"></i> <br> Chose a powerful Password and not less than 6 Letters or Numbers <br> Do not Chose your password in other sites or applications etc ..</p>
              </center>


            </form>
          </div>
          <div class="col-md-3"></div>
        </div>
    </div>

  </div>
</div>
@stop



@section('css')
<style media="screen">



</style>
@stop

@section('js')
<script type="text/javascript">
$(document).ready(function (){
  // Hide All Options in Stages Select
  $("#stgSelect option").each(function(){
      if($(this).val() != 'empty')
      {
        $(this).hide();
      }
  });

  // Using Change Eevent on Department Select
  $("#dptSelect").change(function (){
    var val = $(this).val();
    if(val != 'empty')
    {
      $("#stgSelect option").each(function(){
        if($(this).attr("dpt-id") != 'none')
        {
          if($(this).attr("dpt-id") != val)
          {
            $("#stgSelect").val("empty").change();
            $(this).hide();
          }
          else
          {
            $("#stgSelect").val("empty").change();
            $(this).show();
          }
        }
      });
    }
    else
    {
      // Hide All Options in Stages Seletc if User not Select Department
      $("#stgSelect").val("empty").change();
      $("#stgSelect option").each(function(){
          if($(this).val() != 'empty')
          {
            $(this).hide();
          }
      });
    }
  });
});
</script>
@stop

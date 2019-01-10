@extends('layouts.app')
@section('title')
  Account Delete
@stop

@section('content')

<div class="container">
  @include('includes.parts.msg')
  @include('includes.parts.err')
</div>

<div class="container text-center" style="min-height: 85vh;">
  <h1 style="font-size:8rem;margin-top:50px;font-weight:100;">Delete Account</h1>
  <p style="color:#607D8B; font-size:2rem;">Enter The Current Password To Continue</p>
  <form class="" action="{{ route('profile.delete.execute') }}" method="post">
    {{ csrf_field() }}
    <div class="md-form" style="margin:2.5rem auto;width:300px;">
      <input type="password" name="password" class="form-control" required autofocus autocomplete="new-password">
      <label for="form1" >Password</label>
    </div>
    <button type="submit" name="submit" class="btn btn-danger" style="font-size:1.2rem;width:250px;text-transform:initial;">Delete</button>
    <a href="{{ route('profile.my_profile') }}" class="btn btn-success" style="font-size:1.2rem;width:250px;text-transform:initial;">Cancel</a>
  </form>
</div>
@stop



@section('css')
<style media="screen">

</style>
@stop

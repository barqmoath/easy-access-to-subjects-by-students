@extends('adminlte::page')

@section('title', 'EASS Categories')

@section('content_header')
@include('includes.parts.msg')
@include('includes.parts.err')


<center>
  <h1 style="font-weight:700;font-size:45px;">Categories</h1>
</center>
@stop

@section('content')
  <div class="container">
    <form class="form-inline" action="{{ route('categorys.new_category') }}" method="POST">
      {{ csrf_field() }}
      <div class="form-group">
        <input style="width:250px;" type="text" name="category_name" class="form-control" placeholder="Enter The Category name" required autocomplete="off">
      </div>
      <button style="margin-top:1px;" type="submit" name="submit" class="btn btn-default bg-purple"><i class="fa fa-plus"></i> Add Category</button>
    </form>
  </div>

  <div class="content" style="margin-top:10px;">
    <div class="box box-danger" style="border-radius:0px; border-top-color:#605CA8;">
      <div class="box-body">
        @if(count($categorys) > 0)
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <th>Slug</th>
                <th>Category Name</th>
                <th class="text-center">Action</th>
              </thead>
              <tbody>
                @foreach($categorys as $category)
                  <tr>
                    <td>{{ $category->slug }}</td>
                    <td>{{ $category->category_name }}</td>
                    <td class="text-center">
                      <div class="btn-group">
                        <a href="{{ route('categorys.edit_show',['slug' => $category->slug]) }}" class="btn btn-default btn-sm" style="width:100px;"><i class="fa fa-edit"></i> Edit</a>
                        <a href="{{ route('categorys.delete',['slug' => $category->slug]) }}" onclick="return confirm('Be Careful .. You are about to delete a full category !!!!')" class="btn btn-default btn-sm" style="width:100px;"><i class="fa fa-trash"></i> Delete</a>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <center>
            <h1>NO DATA</h1>
          </center>
        @endif
      </div>
    </div>
  </div>
@stop




@section('css')
  <style media="screen">
       /* body{font-family: Segoe UI;} */
      .content-wrapper {background-color: white;}
  </style>
@stop

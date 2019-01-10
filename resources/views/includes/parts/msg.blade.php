<!-- Success Message -->
@if(session('msg'))
<div class="alert alert-success alert-dismissible text-center" style="border-radius: 0px;border-color: #00a65a; margin: 5px;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-remove"></i></button>
  <h4><i class="icon fa fa-check"></i> {{ session('msg') }}</h4>
</div>
@endif

@if(session('fmsg'))
<div class="alert alert-danger alert-dismissible text-center" style="border-radius: 0px;border-color: red; margin: 5px;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-remove"></i></button>
  <h4><i class="icon fa fa-check"></i> {{ session('fmsg') }}</h4>
</div>
@endif

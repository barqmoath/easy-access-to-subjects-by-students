<!-- Errors Messages -->
@if(count($errors) > 0)
<div class="alert alert-danger alert-dismissible text-center" style="margin:5px; border-radius: 0px;border-color: #721c24;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-remove"></i></button>
  <h4><i class="fa fa-info"></i> Error</h4>
  @foreach($errors->all() as $error)
    <p>{{ $error }}</p>
  @endforeach
</div>
@endif

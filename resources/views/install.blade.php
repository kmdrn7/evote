@extends('layout.app')
@section('title', 'Instalasi')
@section('script')
<meta name="csrf-token" content="{{csrf_token()}}" />
<script type="text/javascript">
$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
	}
});
$(document).ready(function(){
      $('#post').on('click', function(e){
          e.preventDefault();
          $.ajax({
              type: "POST",
              url: "/adduserfirst",
              data: $("#install").serialize(),
              dataType: "json",
              success: function(hasil) {
          		      	  
              },
              error: function(hasil){
              		
              }
          },"json");
          window.location.href = 'login';
      });   
  });
</script>
@endsection

@section('body')
<div class="container">
{!! Form::open(array('url'=>'','id'=>'install','class'=>'login-box-body','style'=>'margin-top:100px')) !!}
    <h2 style="text-align:center;">Welcome to E-vote</h2><hr>
    <div class="form-group">
        <label for="nrp">NRP</label>
            <div class="input-group">
               <span class="input-group-addon"><span class="glyphicon glyphicon-off"></span></span>
                <input type="number" class="form-control" name="nrp" placeholder="NRP..."> 
         </div>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
            <div class="input-group">
               <span class="input-group-addon"><span class="glyphicon glyphicon-cloud"></span></span>
                <input type="password" class="form-control" name="password" placeholder="Password..."> 
         </div>
    </div>
    <div class="form-group">
        <label for="hak_akses">Hak Akses</label>
            <div class="input-group">
               <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                <select name="hak_akses" class="form-control">
                    <option value="0">Administrator</option>
                </select>
         </div>
    </div>
    <div class="form-group">
        <button type="button" class="btn btn-primary" id="post">OK</button>
    </div>
    {!! Form::token() !!}
    <!-- <input type="hidden" name="_token" id="csrf-token" value="{{csrf_token()}}"> -->
{!! Form::close() !!}	
</div>
@endsection
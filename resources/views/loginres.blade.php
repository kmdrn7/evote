@extends('layout.app')
@section('title', 'Login')
@section('body')
<div class="login-box">
  <div class="login-box-body">
    <p class="login-box-msg">Masuk sebagai petugas Observer !</p>

   		{!! Form::open(array('url'=>'result/login')) !!}
	
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="nrp" id="nrp" placeholder="NRP">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" id="password"  placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-12" >
          <button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
        </div>
        		<div class="text-center">&nbsp;
			@if($errors->has('unauth'))
				<span class="label label-danger">{{$errors->first('unauth')}}</span>
			@else
				<span class="label label-warning">Restricted Area !</span>
			@endif
		</div>
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
  @if(isset($jml_login) && $jml_login > 0 && !$errors->has('unauth'))
  <br>
  <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{$data['nama']}} ({{$data['nrp']}}) Telah Login, Jumlah Observer Login = {{$jml_login}}</div>
  @endif
</div>

@endsection
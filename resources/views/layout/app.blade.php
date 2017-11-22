<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<title>@yield('title')</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	@yield('script')
	<style type="text/css">
	.login-page,
	.register-page {
	  background: #d2d6de;
	}
	.login-box,
	.register-box {
	  width: 360px;
	  margin: 7% auto;
	}
	@media (max-width: 768px) {
	  .login-box,
	  .register-box {
	    width: 90%;
	    margin-top: 20px;
	  }
	}
	.login-box-body,
	.register-box-body {
	  background: #fff;
	  padding: 20px;
	  border-top: 0;
	  color: #666;
	}
	.login-box-body .form-control-feedback,
	.register-box-body .form-control-feedback {
	  color: #777;
	}
	.login-box-msg,
	.register-box-msg {
	  margin: 0;
	  text-align: center;
	  padding: 0 20px 20px 20px;
	  	}

	/* card */
.card-custom {
	width: 23%;
	background-color: lightgray;
	float: left;
	margin: 1%;
	position: relative;
}

.card-custom table {
	width: 100%;
	border:1px solid grey;
}

.card-custom tr, .card-custom td {
	border: none;
	background: none;
}

.card-custom tr:hover {
	background: none;
}

.card-custom img {
	width: 100%;
	background: white;
}

.card-custom .card-header h3 {
	text-align: left;
	padding: 0 10px;
}

.card-custom .card-number td h3 {
	text-align: center;
	padding: 5px 0;
	margin: 0;
}
	</style>
	<script type="text/javascript">
		var time = setInterval(myTime, 1000);
		function myTime(){
				$('#time').load("time");
		}
	</script>
</head>
	@if(Auth::check())
<body>
<header class="main" style=" width: 100%; background-color: #0f223c; margin: 0;">
	<div class="col-xs-6">
		<div style="float; left; padding: 15px 20px 0px; 20px; width: 35%; color:#fff; "><span id="time">&nbsp;</span></div>
	</div>
	<div class="col-xs-6">bbb
	</div>
      <nav class="navbar navbar-static-top" style="margin-bottom: 0; display:block;">

      		<div style=""></div>
      		<div style="float:right; padding: 15px 20px 0px; 20px; cursor: pointer; margin-top:0px; width: 25%; color:#fff;">
  		 		<div class="dropdown" style="margin-top:0px; ">
					  <div class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		    				
		  		 			{{Auth::user()->nama}} (
		  		 				@if(Auth::user()->hak_akses == 0)
		  		 					Administrator
		  		 				@elseif(Auth::user()->hak_akses == 1)
		  		 					Observer
		  		 				@elseif(Auth::user()->hak_akses == 2)
		  		 					Operator Registasi
		  		 				@elseif(Auth::user()->hak_akses == 3)
		  		 					Monitoring Room
		  		 				@endif
		  		 			)
					  <span class="caret"></span>
					  </div>
					  <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
					    <li><a href="logout"><span class="glyphicon glyphicon-log-out" aria-hidden="true"> Logout</span></a></li>
					  </ul>
				</div>
  		 		</div>
      </nav>
</header>
  	@else
  	<body style="background-color: #0f223c">

  	@endif
@yield('body')
	<br>
<footer style="background-color: #2a2a2a; min-height: 25px; color: #4d4d4c; padding: 4px; bottom: 0; position: fixed; width: 100%">
    <div align="center">
        <strong>copyright e-Vote<sup>&copy;</sup> - Himpunan Mahasiswa Teknik Informatika - PENS</strong> 
    </div>
</footer>
</body>
</html>

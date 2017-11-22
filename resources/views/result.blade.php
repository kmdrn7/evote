<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/highcharts.js"></script>
	<title>Hasil Pemilu</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script type="text/javascript">
		var time = setInterval(myTime, 1000);
		function myTime(){
				$('#time').load("time");
		}
	</script>
    <style type="text/css">
    #screen {
        background-color: white;
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: 20;
        top: 0px;
        left: 0px;
    }
    #countdown {
        width: 300px;
        height: 300px;
        border-radius: 150px;
        background-color: grey;
        text-align: center;
        position: relative;
        margin: auto;
        top: 200px;
        z-index: 21;
    }

    #countdown h1 {
        color: white;
        font-size: 150px;
        line-height: 300px;
        margin-top: 0;
        margin-bottom: 0;
        padding: 0;
    }

    #start {
        color: white;
        text-decoration: none;
        font-size: 100px;
        top: -20px;
        position: relative;
    }

    ul li {
    	font-size: 20px;
    }
    </style>
</head>
<body>
<header class="main" style=" width: 100%; background-color: #0f223c; margin: 0;">
    <div class="col-xs-6">
            <div style="float; left; padding: 15px 20px 0px; 20px; width: 35%; color:#fff; "><span id="time">&nbsp;</span></div>
        </div>
	<nav class="navbar navbar-static-top" style="margin-bottom: 0; display:block;">
        <div style=""></div>
        <div style="float:right; padding: 15px 20px 0px; 20px; cursor: pointer; margin-top:0px; width: 25%; color:#fff;">
            <div class="dropdown" style="margin-top:0px; ">
                  <div class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Observer Hasil Pemilu
                  <span class="caret"></span>
                  </div>
                  <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                    <li><a href="result/logout"><span class="glyphicon glyphicon-log-out" aria-hidden="true"> Logout</span></a></li>
                  </ul>
            </div>
        </div>
	</nav>
</header>
<h1 align="center">Hasil Pemilihan Umum Presiden BEM PENS</h1>

	<div class="container" style="min-height:500px;">
		<div class="thumbnail col-md-6" align="center">
                <h3>Nomor Urut 1</h3>
                <img alt="Nomor Urut 1" style="height: 250px; display: block;" src="presbem/{{$data['presbem'][1]['data']->foto}}" data-holder-rendered="true">
                <h2 style="@if($data['presbem'][1]['keterangan']) text-decoration: underline; color: green; @endif"> Suara Masuk = {{$data['presbem'][1]['jumlah']}} </h2>
            </div>
            <div class="thumbnail col-md-6" align="center">
                <h3>Nomor Urut 2</h3>
                <img alt="Nomor Urut 2" style="height: 250px; display: block;" src="presbem/{{$data['presbem'][2]['data']->foto}}" data-holder-rendered="true">
                <h2 style="@if($data['presbem'][2]['keterangan']) text-decoration: underline; color: green; @endif"> Suara Masuk = {{$data['presbem'][2]['jumlah']}}</h2>
            </div>
	</div>

	<div class="container">
		<div class="thumbnail col-md-12">
                <div id="grafik-kandidat"></div>
                <div align="center">
            <h2>Jumlah DPT Mendaftar = {{$data['presbem']['all']['jumlah']}} <br> Abstain = {{$data['presbem'][0]['jumlah']}}</h2>
            </div>
            </div>
            
	</div>
	<br>
	<br>
	<br>
	<br>
	<div class="container">
		<h1 align="center">Hasil Pemilihan DPM</h1>
			<div class="thumbnail col-md-4" align="center">
                <h3>{{$data['jur'][0]->jurusan}}</h3>
                <img alt="{{$data['jur'][0]->jurusan}}" style="height: 250px; display: block;" src="dpm/{{$data['dpm'][0]['data']->foto}}" data-holder-rendered="true">
                <h3>Suara Masuk = {{$data['dpm'][0]['jumlah']}} <br>
                Jumlah DPT Mendaftar = {{$data['dpt']['dpm'][0]}} <br>
                Abstain = {{$data['dpm'][0]['abstain']}}</h3>
            </div>
            <div class="thumbnail col-md-4" align="center">
                <h3>{{$data['jur'][1]->jurusan}}</h3>
                <img alt="{{$data['jur'][1]->jurusan}}" style="height: 250px; display: block;" src="dpm/{{$data['dpm'][1]['data']->foto}}" data-holder-rendered="true">
                <h3>Suara Masuk = {{$data['dpm'][1]['jumlah']}} <br>
                Jumlah DPT Mendaftar = {{$data['dpt']['dpm'][1]}} <br>
                Abstain = {{$data['dpm'][1]['abstain']}}</h3>
            </div>
             <div class="thumbnail col-md-4" align="center">
                <h3>{{$data['jur'][2]->jurusan}}</h3>
                <img alt="{{$data['jur'][2]->jurusan}}" style="height: 250px; display: block;" src="dpm/{{$data['dpm'][2]['data']->foto}}" data-holder-rendered="true">
                <h3>Suara Masuk = {{$data['dpm'][2]['jumlah']}} <br>
                Jumlah DPT Mendaftar = {{$data['dpt']['dpm'][2]}} <br>
                Abstain = {{$data['dpm'][2]['abstain']}}</h3>
            </div>
            <div class="thumbnail col-md-4" align="center">
                <h3>{{$data['jur'][3]->jurusan}}</h3>
                <img alt="{{$data['jur'][3]->jurusan}}" style="height: 250px; display: block;" src="dpm/{{$data['dpm'][3]['data']->foto}}" data-holder-rendered="true">
                <h3>Suara Masuk = {{$data['dpm'][3]['jumlah']}} <br>
                Jumlah DPT Mendaftar = {{$data['dpt']['dpm'][3]}} <br>
                Abstain = {{$data['dpm'][3]['abstain']}}</h3>
            </div>
            <div class="thumbnail col-md-4" align="center">
                <h3>{{$data['jur'][4]->jurusan}}</h3>
                <img alt="{{$data['jur'][4]->jurusan}}" style="height: 250px; display: block;" src="dpm/{{$data['dpm'][4]['data']->foto}}" data-holder-rendered="true">
                <h3>Suara Masuk = {{$data['dpm'][4]['jumlah']}} <br>
                Jumlah DPT Mendaftar = {{$data['dpt']['dpm'][4]}} <br>
                Abstain = {{$data['dpm'][4]['abstain']}}</h3>
            </div>
             <div class="thumbnail col-md-4" align="center">
                <h3>{{$data['jur'][6]->jurusan}}</h3>
                <img alt="{{$data['jur'][6]->jurusan}}" style="height: 250px; display: block;" src="dpm/{{$data['dpm'][6]['data']->foto}}" data-holder-rendered="true">
                <h3>Suara Masuk = {{$data['dpm'][6]['jumlah']}} <br>
                Jumlah DPT Mendaftar = {{$data['dpt']['dpm'][6]}} <br>
                Abstain = {{$data['dpm'][6]['abstain']}}</h3>
            </div>
	</div>
	<br>
	<br>
	<br>
	<br>

	<div class="container">
		<h1 align="center">Data Statistik</h1>
		<div class="thumbnail col-md-5">
                <h3>Statistik Pendafataran</h3>
                <ul type="none">
                    <li>Jumlah DPT keseluruhan = {{$data['dpt']['jumlah']}}</li>
                    <li>Jumlah DPT yang mendaftar = {{$data['dpt']['mendaftar']}}</li>
                    <li>Jumlah DPT yang tidak mendaftar = {{$data['dpt']['tidak_daftar']}}</li>
                    <li>&nbsp;</li>
                    <li>&nbsp;</li>
                    <li>&nbsp;</li>
                    <li>&nbsp;</li>
                    <li>&nbsp;</li>
                    <li>&nbsp;</li>
                    <li>&nbsp;</li>
                    <li>&nbsp;</li>
                </ul>
            </div>
            <div class="thumbnail col-md-7">
                <h3>Statistik Pemilihan</h3>
                <ul type="none">
                    <li>Jumlah DPT keseluruhan = {{$data['dpt']['jumlah']}}</li>
                    <li>Jumlah DPT yang memilih Presiden BEM = {{$data['dpt']['bem']['jumlah']}}</li>
                    <li>Jumlah DPT yang memilih DPM = {{$data['dpt']['dpm']['jumlah']}}</li>
                    <li>Jumlah DPT yang abstain Presiden BEM = {{$data['presbem'][0]['jumlah']}}</li>
                    <li>Jumlah DPT yang abstain DPM {{$data['jur'][0]->jurusan}} = {{$data['dpm'][0]['abstain']}}</li>
                    <li>Jumlah DPT yang abstain DPM {{$data['jur'][1]->jurusan}} = {{$data['dpm'][1]['abstain']}}</li>
                    <li>Jumlah DPT yang abstain DPM {{$data['jur'][2]->jurusan}} = {{$data['dpm'][2]['abstain']}}</li>
                    <li>Jumlah DPT yang abstain DPM {{$data['jur'][3]->jurusan}} = {{$data['dpm'][3]['abstain']}}</li>
                    <li>Jumlah DPT yang abstain DPM {{$data['jur'][4]->jurusan}} = {{$data['dpm'][4]['abstain']}}</li>
                    <li>Jumlah DPT yang abstain DPM {{$data['jur'][6]->jurusan}} = {{$data['dpm'][6]['abstain']}}</li>
                    <li>Jumlah DPT yang golput = {{$data['dpt']['tidak_daftar']}}</li>
                </ul>
            </div>
	</div>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	
<br><br><br>
<footer style="background-color: #2a2a2a; min-height: 25px; color: #4d4d4c; padding: 4px; bottom: 0; position: fixed; width: 100%">
    <div align="center">
        <strong>copyright e-Vote<sup>&copy;</sup> - Himpunan Mahasiswa Teknik Informatika - PENS</strong> 
    </div>
</footer>

<div id="screen"><div id="countdown"><h1><a href="#" id="start">Start</a></h1></div></div>

<script>
$(document).ready(function(){
    $('#start').click(function(event) {
        event.preventDefault();
        var counter = 11;
        var id = setInterval(function() {
            counter--;
            if(counter < 0) {
                $('#screen').fadeOut('slow');
                clearInterval(id);
            } else {
                $('#screen #countdown h1').html(counter);
            }
        }, 1000);
    });  

    $("#section-hasil").hide();
    $('#tampil-hasil').click(function(){
        $("#section-form").hide();
        $("#section-hasil").show();
    });

    $('#grafik-kandidat').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Hasil Pemilihan Suara'
        },
        subtitle: {
            text: 'Dari xxx Pemilih'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: "Brands",
            colorByPoint: true,
            data: [{
                name: "Kandidat Nomor Urut 2",
                y: {{$data['presbem'][2]['jumlah']}}
            }, {
                name: "Kandidat Nomor Urut 1",
                y: {{$data['presbem'][1]['jumlah']}}
            }]
        }]
    });
})
</script>
</body>
</html>

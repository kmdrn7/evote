@extends('layout.app')

@if(Auth::user()->hak_akses == 0)
  @section('title','Administrator')
@elseif(Auth::user()->hak_akses == 1)
  @section('title','Observer')
@elseif(Auth::user()->hak_akses == 2)
  @section('title','Operator Registasi')
@elseif(Auth::user()->hak_akses == 3)
  @section('title','Monitoring Room')
@endif

@section('script')
@if($user == 0 || $user == 1)
<script type="text/javascript" src="js/jquery.dynatable.js"></script>
@endif
<link rel="stylesheet" type="text/css" href="css/jquery.dynatable.css">
<link rel="stylesheet" type="text/css" href="css/skinadmin.css">
<script type="text/javascript">
  $('#myTabs a[href="#profile"]').tab('show') // Select tab by name
  $('#myTabs a:first').tab('show') // Select first tab
  $('#myTabs a:last').tab('show') // Select last tab
  $('#myTabs li:eq(2) a').tab('show') // Select third tab (0-indexed)

  $('#myTabs a').click(function (e) {
    e.preventDefault()
    $(this).tab('show')
  })

  $(document).ready(function(){
      $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
          localStorage.setItem('activeTab', $(e.target).attr('href'));
      });
      var activeTab = localStorage.getItem('activeTab');
      if(activeTab){
          $('#myTab a[href="' + activeTab + '"]').tab('show');
      }
@if($user == 0)
      $('#form_dpt').on('submit', function(e){ //Tambah DPT
          e.preventDefault();
          $.ajax({
              type: "POST",
              url: "/adddpt",
              data: $("#form_dpt").serialize(),
              dataType: "json",
              success: function(hasil) {
                  $("#t_dpt").fadeOut();
                  $(".modal-backdrop").fadeOut();
                  document.getElementById("form_dpt").reset();
                  $('#isi_dpt > tbody:last-child').append("<tr><td>"+hasil.i+"</td><td>"+hasil.data.nama+"</td><td>"+hasil.data.nrp+"</td><td>"+hasil.kelas+"</td><td>"+hasil.jurusan+"</td><td>"+hasil.data.status_token+"</td></tr>");
              },
              error: function(){
                console.log('galat');
              }
          },"json");
      }); //End Tambah DPT
      $('#form_tu').on('submit', function(e){ //Tambah User E-Vote
          e.preventDefault();
          $.ajax({
              type: "POST",
              url: "/adduser",
              data: $("#form_tu").serialize(),
              dataType: "json",
              success: function(hasil) {
                  $("#t_user").fadeOut();
                  $(".modal-backdrop").fadeOut();
                  document.getElementById("form_tu").reset();
                  $('#user > tbody:last-child').append("<tr><td>"+hasil.id+"</td><td>"+hasil.nama+"</td><td>"+hasil.nrp+"</td><td>"+hasil.jurusan+"</td><td>"+hasil.hak_akses+"</td></tr>")
              }
          },"json");
      }); //End Tambah User E-Vote
      $('#presbem').on('submit', function(e){ //Tambah PresBem
          e.preventDefault();
          $.ajax({
              type: "POST",
              url: "/addpresbem",
              data: new FormData($("#presbem")[0]),
              dataType: "json",
              processData: false,
              contentType: false,
              success: function(hasil) {
                  $("#t_kandidatpres").fadeOut();
                  $(".modal-backdrop").fadeOut();
                  document.getElementById("presbem").reset();                  
              },
              error: function(){
                  console.log('gagal');
              }
          },"json");
      }); //End Tambah PresBem

      $('#dpm').on('submit', function(e){ //Tambah DPM
          e.preventDefault();
          $.ajax({
              type: "POST",
              url: "/adddpm",
              data: new FormData($("#dpm")[0]),
              dataType: "json",
              processData: false,
              contentType: false,
              success: function(hasil) {
                  $("#t_kandidatdpm").fadeOut();
                  $(".modal-backdrop").fadeOut();
                  document.getElementById("presbem").reset();    
              },
              error: function(){
                  console.log('gagal');
              }
          },"json");
      }); //End Tambah DPM
      $('#isi_dpt').dynatable();
      $('#device').dynatable();
@endif
@if($user == 0 || $user == 1)
      $('#user').dynatable();
      $('#log-tbl').dynatable();
@endif
@if($user == 2)
      $('#token').on('submit', function(e){  //Cari Token
          e.preventDefault();
          $.ajax({
              type: "POST",
              url: "/search",
              data: $("#token").serialize(),
              dataType: "json",
              success: function(isi) {
                  document.getElementById('nrp').innerHTML = (isi.data.nrp);
                  document.getElementById('nama').innerHTML = (isi.data.nama);
                  document.getElementById('jurusan').innerHTML = (isi.jurusan);
                  document.getElementById('kelas').innerHTML = (isi.kelas.tingkat)+" "+(isi.kelas.jenjang)+" "+(isi.kelas.kelas);
                  document.getElementById('status_token').innerHTML = (isi.status);
                  document.getElementById('foto').className="img-rounded";
                  document.getElementById('foto').src="img/"+isi.data.nrp+".PNG";
                  if(isi.data.status_token == 0){
                      document.getElementById('generate').className="btn btn-success btn-sm";
                      document.getElementById('value_token').innerHTML = " ";
                  }
                  else{
                      document.getElementById('generate').className="btn btn-success btn-sm hide";
                      document.getElementById('value_token').innerHTML = (isi.value_token);
                  }
              },
              error: function(){
                  document.getElementById('foto').className="img-rounded hide";
                  document.getElementById('nrp').innerHTML = "Tidak Diketahui";
                  document.getElementById('nama').innerHTML = "Tidak Diketahui";
                  document.getElementById('jurusan').innerHTML = "Tidak Diketahui";
                  document.getElementById('kelas').innerHTML = "Tidak Diketahui";
              }
          },"json");
      });   //End Cari Token
      $('#generate').on('click', function(e){  //Generate Token
          $.ajax({
              type: "POST",
              url: "/generate",
              data: { nrp: document.getElementById('nrp').innerHTML, _token : '{{csrf_token()}}'},
              dataType: "json",
              success: function(ok) {
                  document.getElementById('status_token').innerHTML = (ok.status);
                  document.getElementById('generate').className="btn btn-success btn-sm hide";
                  document.getElementById('value_token').innerHTML = (ok.value_token);
              },
              error: function(){
                  console.log("gagal");
              }
          },"json");
      }); //End Generate Token
@endif


@if($user == 3 || $user == 2)
var i = setInterval(
  function(){
@foreach($device as $dev)
      realTimeStatDev('{{$dev->ip_address}}', 'bilik-{{$dev->name}}');
@endforeach
  },10000
);
@endif
  });

@if($user == 3 || $user == 2)
      function realTimeStatDev(ip, device)
      {
          $.ajax({
          url: '/dev-check/'+ip,
          success: function (result) {
              $.each(result, function (i, hasil) {
                  if(hasil == 'Down') {
                      $('#'+device).removeClass('bg-green');
                      $('#'+device).removeClass('bg-yellow');
                      $('#'+device).addClass('bg-red');
                      $('#'+device+' .stat-dev').html('Terputus');
                  }
                  else {
                    var j = setInterval(
                        realTimeRoom(ip, device), 5000
                    );
                      
                      $('#'+device+' .stat-dev').html('Online');
                  }
              });
          }
          });
      }
      function realTimeRoom(ip, device)
      {
          $.ajax({
          url: '/room-check/'+ip,
          success: function (result) {
              $.each(result, function () {
                  if(result.nrp == '') {
                      $('#'+device).removeClass('bg-red');
                      $('#'+device).removeClass('bg-yellow');
                      $('#'+device).addClass('bg-green');
                      $('#'+device+' .stat-bilik').html(result.stat);
                      $('#'+device+' .stat-nrp').html('');
                  }
                  else {
                      $('#'+device).removeClass('bg-red');
                      $('#'+device).removeClass('bg-green');
                      $('#'+device).addClass('bg-yellow');
                      $('#'+device+' .stat-bilik').html(result.stat);
                      $('#'+device+' .stat-nrp').html(result.nrp);
                  }
              });
          }
          });
      }
@endif
</script>
@endsection

@if($user == 0)
  @section('dpt') <!-- Tab DPT -->
  <div role="tabpanel" class="tab-pane" id="dpt">
  <div class="container">
  <div class="row">
  <br>
  <div style="float:right; margin-right:20px; left:20px; position:relative; top:20px;">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#t_dpt">Tambah DPT</button>
 </div>
  <br>
      <table class="table table-body " width="100%"  id="isi_dpt">
          <thead>
              <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>NRP</th>
                  <th>Kelas</th>
                  <th>Jurusan</th>
                  <th>Status Token</th>
              </tr>
          </thead>
          <tbody>
          <?php $i = 1 ?>
          @foreach($dpt as $isi)
              <tr>
                  <td>{{$i}}</td>
                  <td>{{$isi->nama}}</td>
                  <td>{{$isi->nrp}} </td>
                  <td> {{$kelas[$isi->id_kelas]->tingkat}} {{$kelas[$isi->id_kelas]->jenjang}} {{$kelas[$isi->id_kelas]->kelas}}</td>
                  <td>{{$jurusan[$isi->id_jurusan]->jurusan}}</td>
                  <td>@if($isi->status_token==0)
                        Belum aktif
                      @elseif($isi->status_token==1)
                        Siap Digunakan
                      @elseif($isi->status_token==1)
                        Kadaluarsa / Sudah digunakan
                      </td>
                      @endif
                  <?php $i++ ?>
              </tr>
          @endforeach
          </tbody>
      </table>
  </div>
      <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="t_dpt">
              <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 style="text-align:center;">Tambah DPT</h2>
                </div>
                    <div class="modal-body">        
                    {!! Form::open(array('url'=>'','id'=>'form_dpt')) !!}
                        <div class="form-group">
                            <label for="name">NRP</label>
                                <div class="input-group">
                                   <span class="input-group-addon"><span class="glyphicon glyphicon-off"></span></span>
                                    <input type="number" class="form-control" name="nrp" placeholder="NRP..."> 
                             </div>
                        </div>
                       <div class="form-group">
                            <label for="name">Nama</label>
                                <div class="input-group">
                                   <span class="input-group-addon"><span class="glyphicon glyphicon-off"></span></span>
                                    <input type="text" class="form-control" name="nama" placeholder="Nama..."> 
                             </div>
                        </div>
                        <div class="form-group">
                            <label for="jurusan">Jurusan</label>
                                <div class="input-group">
                                   <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                    <select name="id_jurusan" class="form-control">
                                    @foreach($jurusan as $jur)
                                        <option value="{{$jur->id}}">{{$jur->jurusan}}</option>
                                    @endforeach
                                    </select>
                             </div>
                        </div>
                           <div class="form-group">
                            <label for="kelas">Kelas</label>
                                <div class="input-group">
                                   <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                    <select name="id_kelas" class="form-control">
                                    @foreach($kelas as $kel)
                                        <option value="{{$kel->id}}">{{$kel->tingkat}} {{$kel->jenjang}} {{$kel->kelas}} ({{$kel->tahun}})</option>
                                    @endforeach
                                    </select>
                             </div>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $i?>">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="post">Tambah</button>
                        </div>
                    {!! Form::close() !!}
                    </div>
                    <div style="clear:both;"></div>
                </div>
              </div>
            </div>
  <!-- ========================= --> 
</div>
</div>
  <!-- End DPT -->
  @endsection
@endif
@if($user == 0 || $user == 1)
@section('management_user') <!-- Tab Managemen User-->
<div role="tabpanel" class="tab-pane" id="management_user">

  <!-- ====================== -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="t_user">
              <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 style="text-align:center;">Tambah User</h2>
                </div>
                    <div class="modal-body">        
                    {!! Form::open(array('url'=>'','id'=>'form_tu')) !!}
                        
                        <div class="form-group">
                            <label for="name">NRP</label>
                                <div class="input-group">
                                   <span class="input-group-addon"><span class="glyphicon glyphicon-off"></span></span>
                                    <input type="number" class="form-control" name="nrp" placeholder="NRP..."> 
                             </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Password</label>
                                <div class="input-group">
                                   <span class="input-group-addon"><span class="glyphicon glyphicon-cloud"></span></span>
                                    <input type="password" class="form-control" name="password" placeholder="Password..."> 
                             </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Hak Akses</label>
                                <div class="input-group">
                                   <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                    <select name="hak_akses" class="form-control">
                                        <option value="0">Administrator</option>
                                        <option value="1">Observer</option>
                                        <option value="2">Operator Registrasi</option>
                                        <option value="3">Monitoring Room</option>
                                    </select>
                             </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    {!! Form::close() !!}
                    </div>
                    <div style="clear:both;"></div>
                </div>
              </div>
            </div>
  <!-- ========================= -->
  <div class="container">
<div class="row">
    <br>
  @if($user==0)
  <div style="float:right; margin-right:20px; left:20px; position:relative; top:20px;">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#t_user">Tambah User</button>
 </div>
 @endif
  <br>

        <!-- Table -->
        <table class="table table-body " width="100%" id="user">
            <thead>
              <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>NRP</th>
                  <th>Jurusan</th>
                  <th>Hak Akses</th>
              </tr>
            </thead>
            <tbody>
            @if($user == 0 || $user == 1)
            @foreach($man_user as $a)
              <tr>
                  <td>{{$a->id}}</td>
                  <td>{{$a->nama}}</td>
                  <td>{{$a->nrp}}</td>
                  <td>{{$jurusan[$a->id_jurusan]->jurusan}}</td>
                  <td>@if($a->hak_akses == 0)
                      Administrator
                      @elseif($a->hak_akses == 1)
                      Observer
                      @elseif($a->hak_akses == 2)
                      Operator Registasi
                      @elseif($a->hak_akses == 3)
                      Monitoring Room
                      @endif
                  </td>
              </tr>
            @endforeach
            @endif
            </tbody>
        </table>
      </div>
  </div>
</div>

<!-- End Managemen User-->
@endsection 
@endif
@section('candidate_bem') <!-- Tab Candidate BEM -->
<div role="tabpanel" class="tab-pane" id="candidate_bem">
  <div class="container">
  <div class="row">
    <br><br>
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="t_kandidatpres">
              <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 <h2 style="text-align:center;">Tambah Kandidat Presiden BEM</h2>
                </div>
                    <div class="modal-body">        
                     {!! Form::open(array('id'=>'presbem','files'=>'true','role'=>'form')) !!}
                     <div class="form-group">
                            <label for="name">No. Urut</label>
                                <div class="input-group">
                                   <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                    <input type="number" class="form-control" name="candidate_id" placeholder="Nomor Urut...">
                             </div>
                        </div>
                       <div class="form-group">
                            <label for="name">NRP</label>
                                <div class="input-group">
                                   <span class="input-group-addon"><span class="glyphicon glyphicon-off"></span></span>
                                    <input type="number" class="form-control" name="nrp" placeholder="NRP..."> 
                             </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Visi</label>
                                <div class="input-group">
                                   <span class="input-group-addon"><span class="glyphicon glyphicon-off"></span></span>
                                    <input type="text" class="form-control" name="visi" placeholder="Visi..."> 
                             </div>
                        </div>
                           <div class="form-group">
                            <label for="name">Foto</label>
                                <div class="input-group">
                                   <span class="input-group-addon"><span class="glyphicon glyphicon-off"></span></span>
                                    <input type="file" class="form-control" name="foto" > 
                             </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="post">OK</button>
                        </div>
                    {!! Form::close() !!}
                    </div>
                    <div style="clear:both;"></div>
                </div>
              </div>
            </div>
@if($user == 0)
<div class="container">
     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#t_kandidatpres">Tambah Kandidat</button>
      @foreach($presbem as $bem)
          <div class="card-custom">
            <table>
            <tr>
              <td>
                <img src="presbem/{{$bem->foto}}" alt="">
              </td>
            </tr>
            <tr class="card-number">
              <td><h3>{{$bem->candidate_id}}</h3></td>
            </tr>
            <tr class="card-header">
              <th><h3>{{$bem->nama}}</h3></th>
            </tr>
            </table>
          </div>
      @endforeach
    </div></div>
</div>
@endif

</div><!-- End Candidate BEM -->
@endsection 
@if($user == 0)
@section('candidate_dpm') <!-- Tab Candidate DPM -->
<div role="tabpanel" class="tab-pane" id="candidate_dpm">
    <div class="container">
  <div class="row">
    <br><br>
   <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="t_kandidatdpm">
              <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 <h2 style="text-align:center;">Tambah Kandidat DPM</h2>
                </div>
                    <div class="modal-body">        
                     {!! Form::open(array('id'=>'dpm', 'files'=>'true')) !!}
                     <div class="form-group">
                            <label for="name">No. Urut</label>
                                <div class="input-group">
                                   <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                    <input type="number" class="form-control" name="candidate_id" placeholder="Nomor Urut...">
                             </div>
                        </div>
                       <div class="form-group">
                            <label for="name">NRP</label>
                                <div class="input-group">
                                   <span class="input-group-addon"><span class="glyphicon glyphicon-off"></span></span>
                                    <input type="number" class="form-control" name="nrp" placeholder="NRP..."> 
                             </div>
                        </div>
                        <div class="form-group">
                            <label for="jurusan">Jurusan</label>
                                <div class="input-group">
                                   <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                    <select name="id_jurusan" class="form-control">
                                    @foreach($jurusan as $jur)
                                        <option value="{{$jur->id}}">{{$jur->jurusan}}</option>
                                    @endforeach
                                    </select>
                             </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Visi</label>
                                <div class="input-group">
                                   <span class="input-group-addon"><span class="glyphicon glyphicon-off"></span></span>
                                    <input type="text" class="form-control" name="visi" placeholder="Visi..."> 
                             </div>
                        </div>
                           <div class="form-group">
                            <label for="name">Foto</label>
                                <div class="input-group">
                                   <span class="input-group-addon"><span class="glyphicon glyphicon-off"></span></span>
                                    <input type="file" class="form-control" name="foto"> 
                             </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="post">Tambah</button>
                        </div>
                    {!! Form::close() !!}
                    </div>
                    <div style="clear:both;"></div>
                </div>
              </div>
            </div>
    <div class="container">
     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#t_kandidatdpm">Tambah Kandidat</button>
      @foreach($dpm as $_dpm)
      <div class="card-custom">
            <table>
            <tr>
              <td><h3>{{$jurusan[$_dpm->id_jurusan]->jurusan}}</h3></td>
            </tr>
            <tr>
              <td>
                <img src="dpm/{{$_dpm->foto}}" alt="">
              </td>
            </tr>
            <tr class="card-number">
              <td><h3>{{$_dpm->candidate_id}}</h3></td>
            </tr>
            <tr class="card-header">
              <th><h3>{{$_dpm->nama}}</h3></th>
            </tr>
            </table>
          </div>
      @endforeach
    </div>

</div></div>
</div><!-- End Candidate DPM -->
@endsection 
@endif
@section('management_device') <!-- Tab Management Device -->
<div role="tabpanel" class="tab-pane" id="management_device">
  <div class="container">
  <div class="row">
    <br><br>
    <table class="table table-body " width="100%" id="device">
            <thead>
              <tr>
                  <th>Bilik</th>
                  <th>IP Address</th>
              </tr>
            </thead>
            <tbody>
            @if($user == 0)
            @foreach($device as $a)
              <tr>
                  <td>{{$a->name}}</td>
                  <td>{{$a->ip_address}}</td>
              </tr>
            @endforeach
            @endif
            </tbody>
        </table>
      </div>
    </div>
</div><!-- End Management Device -->
@endsection 

@section('generate_token')  <!-- Tab Generate Token -->
<div role="tabpanel" class="tab-pane active" id="generate_token">
<div class="row">
   <div class="col-xs-6">
    <br>
    <div style="padding: 0px 0px 0px 20px;">
          <!-- Info Boxes Style 2 -->
          

          @foreach($device as $dev)
          <div class="col-md-6">
          <div id="bilik-{{$dev->name}}" class="info-box bg-red">
              <div style="padding:15px;">
                    <h3>BILIK {{$dev->name}}<p style="font-size: 15px">{{$dev->ip_address}}</p></h3>

                    <span class="info-box-number">Status : <span class="stat-bilik"></span></span>
                      <br><span class="info-box-number">NRP : <span class="stat-nrp"></span></span>
                      <br><h3 class="stat-dev"></h3>
              </div>
            <!-- /.info-box-content -->
          </div>
          </div>
          @endforeach
      </div>
   </div>
   <div class="col-xs-6">
      <div class="container">
          <text style="font-size: 15px"><b>Data Pemilih Tetap (DPT)</b></text>
          <form id="token" style="width:50%; margin:0" action="">
                <div class="form-group"><br>
                    <label for="name">Search NRP</label>
                        <div class="input-group">
                           <span class="input-group-addon"><span class="glyphicon glyphicon-off"></span></span>
                            <input type="number" class="form-control" style="z-index:0;" name="nrp" placeholder="NRP"> 
                     </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Check</button>
                </div>
                {!! Form::token() !!}
            </form>
          <div class="row">
              <div class="container">
                    <div class="col-md-2"> <img class="img-rounded hide" id="foto" width="150px;" src="img" alt="User Avatar">
                    </div>
                    <div class="col-md-4">
                      <text>NRP             :</text> <text id="nrp"></text><br>
                      <text>Nama            :</text> <text id="nama"></text><br>
                      <text>Jurusan         :</text> <text id="jurusan"></text><br>
                      <text>Kelas           :</text> <text id="kelas"></text><br>
                      <text>Status Token    :</text> <text id="status_token"></text><br>
                    <button class="btn btn-success btn-sm hide" id="generate">Generate</button>
                     
                    </div>
              </div>
          </div>
        <br>
        <pre class="" style="width: 52%;margin:0;">
        <h1 class="text-center" style="font-size:72px; font-family: monospace ;" id="value_token">&nbsp;</h1>
        </pre>
            
      </div> 

   </div>

</div>


</div><!-- End Generate Token -->
@endsection 

@section('log') <!-- Tab Log -->
<div role="tabpanel" class="tab-pane" id="log">
  <div class="container">
  <div class="row">
    <br><br>
        <table class="table table-body " width="100%" id="log-tbl">
            <thead>
              <tr>
                  <th>NRP</th>
                  <th>Aktifitas</th>
                  <th>Waktu</th>
              </tr>
            </thead>
            <tbody>
            @if($user == 0 || $user == 1)
            @foreach($log as $a)
              <tr>
                  <td>{{$a->nrp}}</td>
                  <td>{{$a->aktivitas}}</td>
                  <td>{{$a->updated_at}}</td>
              </tr>
            @endforeach
            @endif
            </tbody>
        </table>
      </div>
    </div>
</div> <!-- End Log -->
@endsection

@section('room')  <!-- Tab Room -->
<div role="tabpanel" class="tab-pane active" id="room">
  <div class="row">
    <div class="col-xs-12">
    <h3 align="center">Status Bilik</h3>
  </div>
  </div>
  <div class="row">
   <div class="col-xs-12">
    <br>
    <div style="padding: 0px 20px 0px 20px;">
          <!-- Info Boxes Style 2 -->
          @foreach($device as $dev)
          <div class="col-md-4">
            <div id="bilik-{{$dev->name}}" class="info-box bg-red">
                <div style="padding:15px;">
                      <h3>BILIK {{$dev->name}}</h3>
                      <span class="info-box-number">Status : <span class="stat-bilik"></span></span>
                      <br><span class="info-box-number">NRP : <span class="stat-nrp"></span></span>
                      <br><h3 class="stat-dev"></h3>
                </div>
              <!-- /.info-box-content -->
            </div>
          </div>
          @endforeach
      </div>
   </div>
 </div>
</div><!-- End Room -->
@endsection 

@section('body')
<div>
  <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" id="myTab" style="background-color: #fbf257; margin: 0; top:0;">
    @if($user == 0)
      <li role="presentation"><a href="#dpt" aria-controls="dpt" role="tab" data-toggle="tab">DPT</a></li>
      <li role="presentation"><a href="#management_user" aria-controls="management_user" role="tab" data-toggle="tab">Management User</a></li>
      <li role="presentation"><a href="#candidate_bem" aria-controls="candidate_bem" role="tab" data-toggle="tab">Candidate Presiden BEM</a></li>
      <li role="presentation"><a href="#candidate_dpm" aria-controls="candidate_dpm" role="tab" data-toggle="tab">Candidate DPM</a></li>
      <li role="presentation"><a href="#management_device" aria-controls="management_device" role="tab" data-toggle="tab">Management Device</a></li>
      <li role="presentation"><a href="#log" aria-controls="log" role="tab" data-toggle="tab">Log</a></li>
    @elseif($user == 1)
      <li role="presentation" class="active"><a href="#overview" aria-controls="overview" role="tab" data-toggle="tab" aria-expanded="true">Overview</a></li>
      <li role="presentation"><a href="#management_user" aria-controls="management_user" role="tab" data-toggle="tab">Management User</a></li>
      <li role="presentation"><a href="#log" aria-controls="log" role="tab" data-toggle="tab">Log</a></li>
    @elseif($user == 2)
      <li role="presentation" class="active"><a href="#generate_token" aria-controls="generate_token" role="tab" data-toggle="tab" aria-expanded="true">Generate Token</a></li>
    @elseif($user == 3)
      <li role="presentation" class="active"><a href="#room" aria-controls="room" role="tab" data-toggle="tab" aria-expanded="true">Room</a></li>
    @endif
    </ul>
  <!-- Tab panes -->
  <div class="tab-content">
  @if($user == 0)
      @yield('overview')
      @yield('dpt')
      @yield('management_user')
      @yield('candidate_bem')
      @yield('candidate_dpm')
      @yield('management_device')
      @yield('log')
  @elseif($user == 1)
      @yield('overview')
      @yield('management_user')
      @yield('log')
  @elseif($user == 2)
      @yield('generate_token')
  @elseif($user == 3)
      @yield('room')
  @endif
  </div>
</div>
@endsection
@extends('layout.app')
@section('script')
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

      $('#post').on('click', function(e){
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
      });

      $('#token').on('submit', function(e){
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
                  document.getElementById('nrp').innerHTML = "Tidak Diketahui";
                  document.getElementById('nama').innerHTML = "Tidak Diketahui";
                  document.getElementById('jurusan').innerHTML = "Tidak Diketahui";
                  document.getElementById('kelas').innerHTML = "Tidak Diketahui";
              }
          },"json");
      });   
      $('#generate').on('click', function(e){
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
      });
  });
</script>
@endsection

@section('overview') <!-- Tab Overview -->
<div role="tabpanel" class="tab-pane" id="overview">
  A
</div>
@endsection <!-- End Overview -->

@section('dpt') <!-- Tab DPT -->
<div role="tabpanel" class="tab-pane" id="dpt">
  B
</div>
@endsection <!-- End DPT -->

@section('management_user') <!-- Tab Managemen User-->
<div role="tabpanel" class="tab-pane" id="management_user">
  <!-- ====================== -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="t_user">
              <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                    <div class="modal-body">        
                    {!! Form::open(array('url'=>'','id'=>'form_tu')) !!}
                        <h2 style="text-align:center;">Tambah User</h2><hr>
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
                            <button type="button" class="btn btn-primary" id="post">OK</button>
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
                    <div class="col-xs-12">
                          <div class="box">
                              <div class="box-header">
                                  <h3 class="box-title">Responsive Hover Table</h3>
                                  <div class="box-tools">
                                      <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
                                            <div class="input-group-btn">
                                                   <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                            </div>
                                      </div>
                                  </div>
                            </div>
                <!-- /tabel heade -->
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
                                <tr>
                                  <th>ID</th>
                                  <th>User</th>
                                  <th>Date</th>
                                  <th>Status</th>
                                  <th>Reason</th>
                                </tr>
                                <tr>
                                  <td>183</td>
                                  <td>John Doe</td>
                                  <td>11-7-2014</td>
                                  <td><span class="label label-success">Approved</span></td>
                                  <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                </tr>
                                <tr>
                                  <td>219</td>
                                  <td>Alexander Pierce</td>
                                  <td>11-7-2014</td>
                                  <td><span class="label label-warning">Pending</span></td>
                                  <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                </tr>
                                <tr>
                                  <td>657</td>
                                  <td>Bob Doe</td>
                                  <td>11-7-2014</td>
                                  <td><span class="label label-primary">Approved</span></td>
                                  <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                </tr>
                                <tr>
                                  <td>175</td>
                                  <td>Mike Doe</td>
                                  <td>11-7-2014</td>
                                  <td><span class="label label-danger">Denied</span></td>
                                  <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                </tr>
                                </table>
                            </div>
                            <div class="box-footer clearfix">
                                <ul class="pagination pagination-sm no-margin pull-right">
                                      <li><a href="#">&laquo;</a></li>
                                      <li><a href="#">1</a></li>
                                      <li><a href="#">2</a></li>
                                      <li><a href="#">3</a></li>
                                      <li><a href="#">&raquo;</a></li>
                                </ul>
                            </div>
                         </div>
          <!-- /.box -->
                </div>
             </div>


    <br>
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#t_user">Tambah User</button>
   <br><br>
      <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading text-center" style="font-size: 20px">Management User</div>

        <!-- Table -->
        <table class="table table-body" id="user">
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
                  <td>@if($a->id_jurusan == 0)
                          Teknik Elektronika
                      @elseif($a->id_jurusan == 1)
                          Teknik Elektro Industri
                      @elseif($a->id_jurusan == 2)
                          Teknik Informatika
                      @elseif($a->id_jurusan == 3)

                      @elseif($a->id_jurusan == 4)

                      @elseif($a->id_jurusan == 5)

                      @endif
                  </td>
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
@endsection <!-- End Managemen User-->

@section('candidate_bem') <!-- Tab Candidate BEM -->
<div role="tabpanel" class="tab-pane" id="candidate_bem">
  D
</div>
@endsection <!-- End Candidate BEM -->

@section('candidate_dpm') <!-- Tab Candidate DPM -->
<div role="tabpanel" class="tab-pane" id="candidate_dpm">
  E
</div>
@endsection <!-- End Candidate DPM -->

@section('management_device') <!-- Tab Management Device -->
<div role="tabpanel" class="tab-pane" id="management_device">
  F
</div>
@endsection <!-- End Management Device -->

@section('generate_token')  <!-- Tab Generate Token -->
<div role="tabpanel" class="tab-pane" id="generate_token">
  <div class="container"><br>
      
<pre style="width: 50%;margin: auto;">
<text style="font-size: 15px"><b>Data Pemilih Tetap (DPT)</b></text>
<text>NRP             :</text> <text id="nrp"></text>
<text>Nama            :</text> <text id="nama"></text>
<text>Jurusan         :</text> <text id="jurusan"></text>
<text>Kelas           :</text> <text id="kelas"></text>
<text>Status Token    :</text> <text id="status_token"></text><br>
<button class="btn btn-success btn-sm hide" id="generate">Generate</button>
<h2 class="text-center" id="value_token">&nbsp;</h2>
</pre>
    <form id="token" style="width:50%; margin:auto" action="">
        <div class="form-group"><br>
            <label for="name">Search NRP</label>
                <div class="input-group">
                   <span class="input-group-addon"><span class="glyphicon glyphicon-off"></span></span>
                    <input type="number" class="form-control" name="nrp" placeholder="NRP"> 
             </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Check</button>
        </div>
        {!! Form::token() !!}
    </form>
  </div> 
</div>
@endsection <!-- End Generate Token -->

@section('log') <!-- Tab Log -->
<div role="tabpanel" class="tab-pane" id="log">
  H
</div>
@endsection <!-- End Log -->

@section('room')  <!-- Tab Room -->
<div role="tabpanel" class="tab-pane" id="room">
  I
</div>
@endsection <!-- End Room -->

@section('body')
<div>
  <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" id="myTab" style="background-color: #fbf257; margin: 0; top:0;">
    @if($user == 0)
      <li role="presentation"><a href="#overview" aria-controls="overview" role="tab" data-toggle="tab">Overview</a></li>
      <li role="presentation"><a href="#dpt" aria-controls="dpt" role="tab" data-toggle="tab">DPT</a></li>
      <li role="presentation"><a href="#management_user" aria-controls="management_user" role="tab" data-toggle="tab">Management User</a></li>
      <li role="presentation"><a href="#candidate_bem" aria-controls="candidate_bem" role="tab" data-toggle="tab">Candidate Presiden BEM</a></li>
      <li role="presentation"><a href="#candidate_dpm" aria-controls="candidate_dpm" role="tab" data-toggle="tab">Candidate Presiden DPM</a></li>
      <li role="presentation"><a href="#management_device" aria-controls="management_device" role="tab" data-toggle="tab">Management Device</a></li>
      <li role="presentation"><a href="#log" aria-controls="log" role="tab" data-toggle="tab">Log</a></li>
    @elseif($user == 1)
      <li role="presentation"><a href="#overview" aria-controls="overview" role="tab" data-toggle="tab">Overview</a></li>
      <li role="presentation"><a href="#management_user" aria-controls="management_user" role="tab" data-toggle="tab">Management User</a></li>
      <li role="presentation"><a href="#log" aria-controls="log" role="tab" data-toggle="tab">Log</a></li>
    @elseif($user == 2)
      <li role="presentation"><a href="#generate_token" aria-controls="generate_token" role="tab" data-toggle="tab">Generate Token</a></li>
      <li role="presentation"><a href="#room" aria-controls="room" role="tab" data-toggle="tab">Room</a></li>
    @elseif($user == 3)
      <li role="presentation"><a href="#room" aria-controls="room" role="tab" data-toggle="tab">Room</a></li>
    @endif
    </ul>
  <!-- Tab panes -->
  <div class="tab-content" >
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
      @yield('room')
  @elseif($user == 3)
      @yield('room')
  @endif
  </div>
</div>
@endsection
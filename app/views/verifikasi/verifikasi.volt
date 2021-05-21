<!DOCTYPE html>
<html>
<head>
	<title>Lingkar Puan</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container-fluid">
		<nav class="navbar navbar-default" style="background-color: #aacdbe">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="#">Lingkar Puan</a>
		    </div>
		    <ul class="nav navbar-nav">
		      <li class="dropdown">
		        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Artikel
		        <span class="caret"></span></a>
		        <ul class="dropdown-menu">
		          <li><a href="{{ url('artikel/') }}">Baca Artikel</a></li>
		          <li><a href="{{ url('artikelsaya/buat') }}">Kirim Artikel</a></li>
		          <li><a href="#">Artikel Saya</a></li>
		        </ul>
		      </li>
		      <li class="dropdown">
		        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Konsultasi
		        <span class="caret"></span></a>
		        <ul class="dropdown-menu">
		          <li><a href="#">Psikologi</a></li>
		          <li><a href="#">Hukum</a></li>
		        </ul>
		      </li>
		    </ul>
		    {% if(session.get('user')) %}
		    	<ul class="nav navbar-nav navbar-right">
			      <li><a href="{{ url('user/logout') }}"><span class="glyphicon glyphicon-log-in"></span> Keluar</a></li>
			    </ul>
		    {% else %}
			    <ul class="nav navbar-nav navbar-right">
			      <li><a href="{{ url('user/register') }}"><span class="glyphicon glyphicon-user"></span> Buat Akun</a></li>
			      <li><a href="{{ url('user/login') }}"><span class="glyphicon glyphicon-log-in"></span> Masuk</a></li>
			    </ul>
		    {% endif %}
		  </div>
		</nav>
	  <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#tab1">Verifikasi Artikel</a></li>
      <li><a data-toggle="tab" href="#tab2">Konfirmasi Penulis</a></li>
    </ul>

    <div class="tab-content">
      <div id="tab1" class="tab-pane fade in active">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Judul</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            {% for verifikasi in data_verifikasi %}
              <tr>
              <td>{{verifikasi.judul}}</td>
              <td><a href="detail/{{verifikasi.id_artikel}}" class="btn btn-primary" target="blank">Detail Artikel</a></td>
            </tr>
            {% endfor %}
          </tbody>
        </table>
      </div>
      <div id="tab2" class="tab-pane fade">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Judul</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            {% for konfirmasi in data_konfirmasi %}
              <tr>
              <td>{{konfirmasi['judul']}}</td>
              <td>{{konfirmasi['status']}}</td>
              <td><a href="detail/{{konfirmasi['id_artikel']}}" class="btn btn-primary" target="blank">Detail Artikel</a></td>
            </tr>
            {% endfor %}
          </tbody>
        </table>
      </div>
    </div>
	  
	</div>
</body>
</html>
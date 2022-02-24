<div class="container">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav">
        <!-- <li class="nav-item">
          <a class="nav-link" href="#"><i class="fa fa-home"></i> Home</a>
        </li> -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-th-large"></i> Master
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#" onclick="loadPage('a_posko');"><i class="fa fa-hospital-o mr-1"></i> Data Posko</a>
            <a class="dropdown-item" href="#" onclick="loadPage('a_admin');"><i class="fa fa-user mr-1"></i> Data Admin</a>
            <a class="dropdown-item" href="#" onclick="loadPage('a_donatur');"><i class="fa fa-heart mr-1"></i> Data Donatur</a>
            <a class="dropdown-item" href="#" onclick="loadPage('a_kategori_barang');"><i class="fa fa-tag mr-1"></i> Data Kategori Barang</a>
            <a class="dropdown-item" href="#" onclick="loadPage('a_barang');"><i class="fa fa-suitcase mr-1"></i> Data Barang</a>
            <a class="dropdown-item" href="#" onclick="loadPage('a_relawan');"><i class="fa fa-user-circle-o mr-1"></i> Data Jenis Relawan</a>
            <a class="dropdown-item" href="#" onclick="loadPage('a_satuan');"><i class="fa fa-ellipsis-h mr-1"></i> Data Satuan</a>
            <a class="dropdown-item" href="#" onclick="loadPage('a_kriteria');"><i class="fa fa-file-text-o mr-1"></i> Data Kriteria</a>
            <a class="dropdown-item" href="#" onclick="loadPage('a_kriteria_sub');"><i class="fa fa-file-text-o mr-1"></i> Data Sub Kriteria</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" onclick="loadPage('a_korban');"><i class="fa fa-users"></i> Data Korban</a>
        </li>     
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-inbox"></i> Pemasukan
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#" onclick="loadPage('a_pemasukan');"><i class="fa fa-plus-square mr-1"></i> Tambah</a>
            <a class="dropdown-item" href="#" onclick="loadPage('a_pemasukan_daf');"><i class="fa fa-list-ul mr-1"></i> Daftar</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-share-square"></i> Pengeluaran
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#" onclick="loadPage('a_pengeluaran');"><i class="fa fa-plus-square mr-1"></i> Tambah</a>
            <a class="dropdown-item" href="#" onclick="loadPage('a_pengeluaran_daf');"><i class="fa fa-list-ul mr-1"></i> Daftar</a>
          </div>
        </li>  
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-ambulance"></i> Distribusi
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#" onclick="loadPage('a_distribusi');"><i class="fa fa-plus-square mr-1"></i> Tambah</a>
            <a class="dropdown-item" href="#" onclick="loadPage('a_distribusi_daf');"><i class="fa fa-list-ul mr-1"></i> Daftar</a>
          </div>
        </li>  
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-medkit"></i> Persediaan
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#" onclick="loadPage('a_stok');"><i class="fa fa-hospital-o mr-1"></i> Posko Induk</a>
            <a class="dropdown-item" href="#" onclick="loadPage('a_stok_posko');"><i class="fa fa-hospital-o mr-1"></i> Posko Lainnya</a>
          </div>
        </li>  
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-gears"></i> Prioritas
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#" onclick="loadPage('a_set_kriteria');"><i class="fa fa-file-text-o mr-1"></i> Set Kriteria</a>
            <a class="dropdown-item" href="#" onclick="loadPage('a_set_bobot_kriteria');"><i class="fa fa-file-text-o mr-1"></i> Set Bobot Kriteria</a>
            <a class="dropdown-item" href="#" onclick="loadPage('a_alternatif_pp');"><i class="fa fa-file-text-o mr-1"></i> Alternatif Posko Prioritas</a>
            <a class="dropdown-item" href="#" onclick="loadPage('a_alternatif_p');"><i class="fa fa-file-text-o mr-1"></i> Posko Prioritas</a>
          </div>
        </li>  
        
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Dropdown
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li> -->
      </ul>
    </div>
</div>

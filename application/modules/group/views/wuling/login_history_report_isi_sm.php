
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 p-0 mt-1">   
        <h5>Not Logged In The Last 2 Days</h5>
        <div class="table-responsive">      
        <table class="table table-bordered table-hover nowrap" id="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class=""><b>NIK</b></th>
                         <th scope="col" class=""><b>Job Desc</b></th>
                         <th scope="col" class=""><b>Name</b></th>
                         <th scope="col" class=""><b>Last time login</b></th>
                    </tr>
                </thead>
                <tbody>
                 <?php
                    $q_l = $this->db->query("SELECT sl.id_sales,sl.id_leader,k.nik,k.nama_karyawan,k.id_perusahaan,k.id_jabatan FROM db_wuling.adm_sales sl 
                    LEFT JOIN (SELECT id_sales,time_login, MAX(id) AS maxid FROM db_wuling.history_login_sales GROUP BY id_sales) AS hls ON hls.id_sales = sl.id_sales LEFT JOIN db_wuling.history_login_sales AS hls2 ON hls2.id = hls.maxid
                    JOIN kmg.karyawan k ON k.id_karyawan = sl.id_sales 
                    WHERE sl.status_leader='sm' AND sl.status_aktif='A' 
                    AND ((hls2.time_login is NULL) OR (DATE(hls2.time_login)<DATE(DATE_SUB(CURDATE(),INTERVAL 2 DAY))))
                    ORDER BY k.id_perusahaan");
                    $tot_l=$q_l->num_rows();
                    if($tot_l>0){
                        $i=1;
                        foreach($q_l->result() as $l){
                            $log_akhir=$this->db_wuling->query("SELECT max(time_login) as latest FROM history_login_sales WHERE id_sales='$l->id_sales'")->row()->latest;
                            $branch=$this->model_data->getlokasiperusahaan($l->id_perusahaan);
                            $jabatan=$this->model_data->JabatanToKaryawan($l->id_jabatan);
                            echo '<tr>';
                            echo '<td class="">'.$l->nik.'</td>';
                            echo '<td class="">'.$jabatan.'</td>';
                            echo '<td class="">'.$l->nama_karyawan.'</td>';
                            echo '<td class="text-center">'.datetime_show($log_akhir).'</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>      
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-12 col-md-12 col-sm-12 p-0 mt-1">   
        <h5>Last Time Login</h5>
        <div class="table-responsive">      
        <table class="table table-bordered table-hover nowrap" id="table_2">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class=""><b>NIK</b></th>
                         <th scope="col" class=""><b>Job Desc</b></th>
                         <th scope="col" class=""><b>Name</b></th>
                         <th scope="col" class=""><b>Last time login</b></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q_l = $this->db->query("SELECT sl.id_sales,sl.id_leader,k.nik,k.nama_karyawan,k.id_perusahaan,k.id_jabatan FROM db_wuling.adm_sales sl 
                    JOIN kmg.karyawan k ON k.id_karyawan = sl.id_sales 
                    WHERE sl.status_leader='sm' AND sl.status_aktif='A' ORDER BY k.id_perusahaan");
                    $tot_l=$q_l->num_rows();
                    if($tot_l>0){
                        $i=1;
                        foreach($q_l->result() as $l){
                            $log_akhir=$this->db_wuling->query("SELECT max(time_login) as latest FROM history_login_sales WHERE id_sales='$l->id_sales'")->row()->latest;
                            $branch=$this->model_data->getlokasiperusahaan($l->id_perusahaan);
                            $jabatan=$this->model_data->JabatanToKaryawan($l->id_jabatan);
                            echo '<tr>';
                            echo '<td class="">'.$l->nik.'</td>';
                            echo '<td class="">'.$jabatan.'</td>';
                            echo '<td class="">'.$l->nama_karyawan.'</td>';
                            echo '<td class="text-center">'.datetime_show($log_akhir).'</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>      
    </div>
</div>

<script>
    $('document').ready(function(){   
        $("#table").DataTable();
        $("#table_2").DataTable();
      
    });
</script>

<script>
    $('#loading').hide();
</script>
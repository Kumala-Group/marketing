
<div class="row-fluid">
<div class="table-header">
    <?php echo $judul;
    ?>
    <div class="widget-toolbar no-border pull-right">
    </div>
</div>
<table class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">NIK</th>
            <th class="center">Nama Pengadu</th>
            <th class="center">Cabang</th>
            <th class="center">Estimasi Waktu</th>
            <th class="center">Masalah</th>
            <th class="center">Prioritas</th>
            <th class="center">Status Tiket</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->nik;?></td>
            <td class="center"><?php echo $dt->nama_karyawan;?></td>
            <td class="center"><?php echo $dt->nama_brand.' - '.$dt->lokasi;?></td>
            <td class="center"><?php
            $id_tiket = $dt->id_tiket;
            //SELECT timediff (solving.waktu_selesai,(SELECT TIMESTAMP(tiket.tgl_tiket,tiket.wkt_tiket))) AS estimasi FROM solving,tiket WHERE solving.id_tiket='15' && solving.id_tiket=tiket.id_tiket
            //SELECT timediff (s.waktu_selesai,t.wkt_tiket) AS estimasi FROM solving s,tiket t WHERE s.id_tiket='$id_tiket' && s.id_tiket=t.id_tiket
            $dataa = $this->db_helpdesk->query("SELECT timediff (solving.waktu_selesai,(SELECT TIMESTAMP(tiket.tgl_tiket,tiket.wkt_tiket))) AS estimasi FROM solving,tiket WHERE solving.id_tiket='$id_tiket' && solving.id_tiket=tiket.id_tiket");
            foreach($dataa->result() as $dt_nm)
            {
              $estimasi= $dt_nm->estimasi;
              $exp = explode(':',$estimasi);
              if(count($exp) == 3) {
              $estimasi = $exp[0].' Jam '.$exp[1].' Menit '.$exp[2].' Detik';
              }
              echo $estimasi;
            }
            ?></td>
            <td class="center"><?php echo $dt->masalah;?></td>
            <td class="center">
              <?php
              if($dt->priority == 'Urgent'){
                echo "<button style='background-color:#ff4000;border: none;color: black;padding: 1px 7px;text-align: center;text-decoration: none;display: inline-block;font-size: 11px;'>";
              }elseif ($dt->priority == 'High') {
                echo "<button style='background-color:#ff8000;border: none;color: black;padding: 1px 13px;text-align: center;text-decoration: none;display: inline-block;font-size: 11px;'>";
              }elseif ($dt->priority == 'Normal') {
                echo "<button style='background-color:#ffbf00;border: none;color: black;padding: 1px 6px;text-align: center;text-decoration: none;display: inline-block;font-size: 11px;'>";
              }else {
                echo "<button style='background-color:#ffff00;border: none;color: black;padding: 1px 15px;text-align: center;text-decoration: none;display: inline-block;font-size: 11px;'>";
              }
              ?>

              <?php echo $dt->priority;?></button>
            </td>
            <td class="center">
              <?php echo $dt->status_tiket;
              if ($dt->status_tiket=='OnHold' or $dt->status_tiket=='Pending') {
                echo " by ";
                $data = $this->db_helpdesk->from('t_solving')->where('id_tiket',$dt->id_tiket)->get();
                foreach($data->result() as $dt_by)
    						{
                  $dataa = $this->db->from('karyawan')->where('nik',$dt_by->nik_exe)->get();
                  foreach($dataa->result() as $dt_nm)
      						{
                    echo $dt_nm->nama_karyawan;
      						}
    						}
              }
              else if ($dt->status_tiket=='Solved') {
                echo " by ";
                $data = $this->db_helpdesk->from('solving')->where('id_tiket',$dt->id_tiket)->get();
                foreach($data->result() as $dt_by)
    						{
                  $dataa = $this->db->from('karyawan')->where('nik',$dt_by->nik_exe)->get();
                  foreach($dataa->result() as $dt_nm)
      						{
                    echo $dt_nm->nama_karyawan;
      						}
    						}
              }


              ?>
            </td>

        </tr>
        <?php } ?>
    </tbody>

</table>
</div>

<div id="modal-table" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Pilih Eksekutor
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
              <input type="text" name="id_tiket"id="id_tiket">
            <input type="hidden" name="id_t_solv"id="id_t_solv">
          <input type="hidden" name="waktu_mulai"id="waktu_mulai">
            <br>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Status Tiket</label>
                <div class="controls">
                  <select name="status_tiket" id="status_tiket">
                    <option value="Pending">Pending</option>
                    <option value="Solved">Solved</option>
                    <option value="OnHold">OnHold</option>
                    <option value="Open">Open</option>

                   </select>
                </div>
            </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">NIK Eksekutor</label>

                    <div class="controls">
                        <input type="text" name="nik_exe" id="nik_exe" placeholder="NIK Eksekutor"/>

                        <button type="button" name="cari_karyawan" id="cari_karyawan" class="btn btn-small btn-info">
                          <i class="icon-search"></i>
                        </button>
                    </div>

                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Eksekutor</label>

                    <div class="controls">
                        <input type="text" name="nama_exe" id="nama_exe" placeholder="Nama Eksekutor" readonly/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">NIK Pengadu</label>

                    <div class="controls">
                        <input type="text" name="nik" id="nik" readonly/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Karyawan Pengadu</label>

                    <div class="controls">
                        <input type="text" name="nama_pengadu" id="nama_pengadu" readonly/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Cabang</label>

                    <div class="controls">
                        <input type="text" name="cabang" id="cabang" readonly/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Masalah</label>

                    <div class="controls">
                        <textarea name="masalah" id="masalah" disabled>
</textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Prioritas</label>

                    <div class="controls">
                        <input type="text" name="priority" id="priority" readonly/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Waktu Tiket</label>

                    <div class="controls">
                        <input type="text" name="waktu_tiket" id="waktu_tiket" readonly/>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-footer">
        <div class="pagination pull-right no-margin">
        <button type="button" class="btn btn-small btn-danger pull-left" data-dismiss="modal">
            <i class="icon-remove"></i>
            Close
        </button>
        <button type="button" name="simpan" id="simpan" class="btn btn-small btn-success pull-left">
            <i class="icon-save"></i>
            Simpan
        </button>
        </div>
    </div>
</div>

<div id="modal-search" class="modal hide fade" style="width:80%;max-height:80%;left:30%;" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Daftar Staff IT
        </div>
    </div>

    <div class="no-padding">
        <div class="row-fluid">
          <table class="table lcnp table-striped table-bordered table-hover" style="width: 100%;" id="show_karyawan">
              <thead>
                  <tr>
                      <th class="center">No</th>
                      <th class="center">NIK</th>
                      <th class="center">Nama Karyawan</th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
          </table>
        </div>
    </div>

    <div class="modal-footer">
        <div class="pagination pull-right no-margin">
        <button type="button" class="btn btn-small btn-danger pull-left" data-dismiss="modal">
            <i class="icon-remove"></i>
            Close
        </button>
        </div>
    </div>
</div>

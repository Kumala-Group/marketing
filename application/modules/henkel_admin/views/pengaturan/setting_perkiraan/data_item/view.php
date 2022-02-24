<script type="text/javascript">
$(document).ready(function(){

    $("#simpan").click(function(){
        var kode_gudang = $("#kode_gudang").val();
        var kode_item = $("#kode_item").val();
        var nama_item = $("#nama_item").val();
        var tipe = $("#tipe").val();
        var harga_perkiraan = $("#harga_perkiraan").val();
        var tambah_stok = $("#tipe").val();

        var string = $("#my-form").serialize();


        if (kode_gudang=='') {
          $.gritter.add({
              title: 'Peringatan..!!',
              text: 'Kode Gudang tidak boleh kosong',
              class_name: 'gritter-error'
          });
          $("#kode_gudang").focus();
          return false();
        }

        if (nama_item=='') {
          $.gritter.add({
              title: 'Peringatan..!!',
              text: 'Nama Item tidak boleh kosong',
              class_name: 'gritter-error'
          });
          $("#nama_item").focus();
          return false();
        }

        if (kode_item=='') {
          $.gritter.add({
              title: 'Peringatan..!!',
              text: 'Kode Item tidak boleh kosong',
              class_name: 'gritter-error'
          });
          $("#kode_item").focus();
          return false();
        }

        if(tipe==''){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Tipe tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#tipe").focus();
            return false();
        }

        if(harga_perkiraan==''){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Harga Perkiraan tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#harga_perkiraan").focus();
            return false();
        }

        if(tambah_stok==''){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Tambah Stok tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#tambah_stok").focus();
            return false();
        }

        $.ajax({
            type    : 'POST',
            url     : "<?php echo site_url(); ?>henkel_adm_stok_awal_item/simpan",
            data    : string,
            cache   : false,
            success : function(data){
                alert(data);
                location.reload();
            }
        });
    });


});

function editData(ID){
    var cari    = ID;
    console.log(cari);
    $.ajax({
        type    : "GET",
        url     : "<?php echo site_url(); ?>henkel_adm_stok_awal_item/cari",
        data    : "cari="+cari,
        dataType: "json",
        success : function(data){
            $('#id_stok_awal_item').val(data.id_stok_awal_item);
            $('#tanggal').val(data.tanggal);
            $('#kode_gudang').html(data.kode_gudang);
            $('#kode_item').val(data.kode_item);
            $('#nama_item').val(data.nama_item);
            $('#tipe').val(data.tipe);
            $('#harga_perkiraan').val(data.harga_perkiraan);
            $('#tambah_stok').val(data.tambah_stok);
        }
    });
}
</script>

<div id="modal-table" >
    <div class="modal-header no-padding">
        <div class="table-header">
            Data Akun Perkiraan
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="form-data" id="form-data">
            <input type="hidden" name="id_stok_awal_item" id="id_stok_awal_item" />
            <br>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Harga Pokok Penjualan</label>
                <div class="controls">
                  <?php ?>
                  <select name="kode_akun" id="kode_akun">
                    <option value="" selected="selected">--Pilih Nama Akun--</option>
                    <?php
                      $data = $this->db_kpp->get('akun');
                      foreach($data->result() as $dt){
                    ?>
                     <option value="<?php echo $dt->kode_akun;?>"><?php echo $dt->kode_akun.' - '.$dt->nama_akun;?></option>
                    <?php
                      }
                    ?>
                   </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Pendapatan Jual</label>
                <div class="controls">
                  <?php ?>
                  <select name="kode_akun" id="kode_akun">
                    <option value="" selected="selected">--Pilih Nama Akun--</option>
                    <?php
                      $data = $this->db_kpp->get('akun');
                      foreach($data->result() as $dt){
                    ?>
                     <option value="<?php echo $dt->kode_akun;?>"><?php echo $dt->kode_akun.' - '.$dt->nama_akun;?></option>
                    <?php
                      }
                    ?>
                   </select>
                   </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Pendapatan Jasa</label>
                    <div class="controls">
                      <?php ?>
                      <select name="kode_akun" id="kode_akun">
                        <option value="" selected="selected">--Pilih Nama Akun--</option>
                        <?php
                          $data = $this->db_kpp->get('akun');
                          foreach($data->result() as $dt){
                        ?>
                         <option value="<?php echo $dt->kode_akun;?>"><?php echo $dt->kode_akun.' - '.$dt->nama_akun;?></option>
                        <?php
                          }
                        ?>
                       </select>
                       </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="form-field-1">Persediaan</label>
                        <div class="controls">
                          <?php ?>
                          <select name="kode_akun" id="kode_akun">
                            <option value="" selected="selected">--Pilih Nama Akun--</option>
                            <?php
                              $data = $this->db_kpp->get('akun');
                              foreach($data->result() as $dt){
                            ?>
                             <option value="<?php echo $dt->kode_akun;?>"><?php echo $dt->kode_akun.' - '.$dt->nama_akun;?></option>
                            <?php
                              }
                            ?>
                           </select>
                           </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="form-field-1">Non Inventory</label>
                            <div class="controls">
                              <?php ?>
                              <select name="kode_akun" id="kode_akun">
                                <option value="" selected="selected">--Pilih Nama Akun--</option>
                                <?php
                                  $data = $this->db_kpp->get('akun');
                                  foreach($data->result() as $dt){
                                ?>
                                 <option value="<?php echo $dt->kode_akun;?>"><?php echo $dt->kode_akun.' - '.$dt->nama_akun;?></option>
                                <?php
                                  }
                                ?>
                               </select>
                               </div>
                            </div>
            </form>
        </div>
    </div>

    <br />

    <div class="modal-header no-padding">
        <div class="table-header">
            Data Akun Saldo Awal, Item Masuk & Keluar
        </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="form-akun-saldo-awal" id="form-akun-saldo-awal">
            <input type="hidden" name="id_stok_awal_item" id="id_stok_awal_item" />
            <br>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Item Masuk</label>
                <div class="controls">
                  <?php ?>
                  <select name="kode_akun" id="kode_akun">
                    <option value="" selected="selected">--Pilih Nama Akun--</option>
                    <?php
                      $data = $this->db_kpp->get('akun');
                      foreach($data->result() as $dt){
                    ?>
                     <option value="<?php echo $dt->kode_akun;?>"><?php echo $dt->kode_akun.' - '.$dt->nama_akun;?></option>
                    <?php
                      }
                    ?>
                   </select>
                </div>
            </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Item Keluar</label>
                    <div class="controls">
                      <?php ?>
                      <select name="kode_akun" id="kode_akun">
                        <option value="" selected="selected">--Pilih Nama Akun--</option>
                        <?php
                          $data = $this->db_kpp->get('akun');
                          foreach($data->result() as $dt){
                        ?>
                         <option value="<?php echo $dt->kode_akun;?>"><?php echo $dt->kode_akun.' - '.$dt->nama_akun;?></option>
                        <?php
                          }
                        ?>
                       </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Item Opname</label>
                    <div class="controls">
                      <?php ?>
                      <select name="kode_akun" id="kode_akun">
                        <option value="" selected="selected">--Pilih Nama Akun--</option>
                        <?php
                          $data = $this->db_kpp->get('akun');
                          foreach($data->result() as $dt){
                        ?>
                         <option value="<?php echo $dt->kode_akun;?>"><?php echo $dt->kode_akun.' - '.$dt->nama_akun;?></option>
                        <?php
                          }
                        ?>
                       </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Saldo Awal Item</label>
                    <div class="controls">
                      <?php ?>
                      <select name="kode_akun" id="kode_akun">
                        <option value="" selected="selected">--Pilih Nama Akun--</option>
                        <?php
                          $data = $this->db_kpp->get('akun');
                          foreach($data->result() as $dt){
                        ?>
                         <option value="<?php echo $dt->kode_akun;?>"><?php echo $dt->kode_akun.' - '.$dt->nama_akun;?></option>
                        <?php
                          }
                        ?>
                       </select>
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
<script type="text/javascript">
function justAngka(e){
       // Allow: backspace, delete, tab, escape, enter and .
       if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A, Command+A
           (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right, down, up
           (e.keyCode >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything
                return;
       }
       // Ensure that it is a number and stop the keypress
       if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
           e.preventDefault();
       }
};
</script>

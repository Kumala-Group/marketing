
<div class="row mb-3" style="box-shadow: 0px 7px 6px -4px #a5a4a4;">
    <div class="col-lg-12 col-md-12 col-sm-12 p-0 mt-md-2 mt-2">   
        <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 p-0">
                    <div class="widget-card">
                        <div class="widget-icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="widget-data">
                            <h3><?=$this->db_wuling->select('id_sales')->where("status_leader='n' AND status_aktif='A'")->get('adm_sales')->num_rows();?></h3>
                            <p>Data</p>
                            <h5>Sales</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 p-0">
                    <div class="widget-card">
                        <div class="widget-icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="widget-data">
                            <h3><?=$this->db_wuling->select('id_sales')->where("status_leader='s' AND status_aktif='A'")->get('adm_sales')->num_rows();?></h3>
                            <p>Data</p>
                            <h5>Supervisor</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 p-0">
                    <div class="widget-card">
                        <div class="widget-icon">
                            <i class="fa fa-user-circle"></i>
                        </div>
                        <div class="widget-data">
                            <h3><?=$this->db_wuling->select('id_sales')->where("status_leader='sm' AND status_aktif='A'")->get('adm_sales')->num_rows();?></h3>
                            <p>Data</p>
                            <h5>Sales Manager</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 p-0">
                    <div class="widget-card">
                        <div class="widget-icon">
                            <i class="fa fa-building"></i>
                        </div>
                        <div class="widget-data">
                            <h3><?=$this->db->select('id_perusahaan')->where("id_brand='5' AND kode_perusahaan NOT LIKE '%HO%'")->get('perusahaan')->num_rows();?></h3>
                            <p>Data</p>
                            <h5>Branch</h5>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 p-0 mt-md-2 mt-2">   
    <form>
        <div class="form-row">
            <div class="form-group col-md-2 col-12">
            <label for="thn">Year</label>
                <?php $thn_skrng = date('Y'); ?>
                <select name="thn" id="thn" class="form-control">
                    <?php
                    for ($thn = $thn_skrng; $thn >= 1994; $thn--) {
                        echo "<option value=$thn>$thn</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-2 col-12">
            <label for="unit_model">Unit Model</label>
                <select id="unit_model" name="unit_model" class="form-control">
                    <option value="all" selected>All Model</option>
                    <?php
                    $q_model=$this->db_wuling->select('id_model,model')->get('p_model')->result();
                    ?>
                    <?php foreach ($q_model as $dt) : ?>                                            
                        <option value="<?php echo $dt->id_model;?>"><?php echo $dt->model?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-md-1 col-12">
            <label for="">&nbsp;</label>
            <button type="button" id="check" class="btn btn-primary form-control"><i class="fa fa-check-square mr-1"></i> Check</button>
            </div>
        </div>
    </form>
    </div>
</div>

<div id="view"></div>

<script>
    $('document').ready(function(){   
        var unit_model = $("#unit_model").val();
        var thn = $("#thn").val();
        view_data(thn,unit_model);
        
        $("#check").click(function() {
            var unit_model = $("#unit_model").val();
            var thn = $("#thn").val();
            view_data(thn,unit_model);
           
        });
    });

    function view_data(thn,unit_model){
        var param = $("#check");
        $.ajax({
                type: "POST",
                url: "<?php echo site_url(); ?>g_wuling_sales_report/data",
                data: {
                    unit_model: unit_model,
                    thn: thn
                },
                beforeSend: function() {
                        process1(param);
                },
                success: function(data) {
                    $('#view').html(data);
                    process_done1(param,'<i class="fa fa-check-square mr-1"></i> Check'); 
                }
            });
    }
</script>
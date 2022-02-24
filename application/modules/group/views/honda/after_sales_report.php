<div class="row mb-3" style="box-shadow: 0px 7px 6px -4px #a5a4a4;">
    <div class="col-lg-12 col-md-12 col-sm-12 p-0 mt-md-2 mt-2">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 p-0">
                <div class="widget-card">
                    <div class="widget-icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="widget-data">
                        <h3><?= $mekanik ?></h3>
                        <p>Jabatan</p>
                        <h5>Mekanik</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 p-0">
                <div class="widget-card">
                    <div class="widget-icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="widget-data">
                        <h3><?= $service_advisor ?></h3>
                        <p>Jabatan</p>
                        <h5>Service Advisor</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 p-0">
                <div class="widget-card">
                    <div class="widget-icon">
                        <i class="fa fa-user-circle"></i>
                    </div>
                    <div class="widget-data">
                        <h3><?= $foreman ?></h3>
                        <p>Jabatan</p>
                        <h5>Foreman</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 p-0">
                <div class="widget-card">
                    <div class="widget-icon">
                        <i class="fa fa-building"></i>
                    </div>
                    <div class="widget-data">
                        <h3><?= $admin ?></h3>
                        <p>Jabatan</p>
                        <h5>Admin</h5>
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
                <!-- <div class="form-group col-md-2 col-12">
                    <label for="mont">Month</label>
                    <select name="month" id="month" class="form-control">
                        <?php
                        $bln = (int) date('m');
                        $bulan = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                        for ($i = 1; $i <= 12; $i++) {
                            $bulan1 = sprintf("%02d", $i);
                            if ($bln == $i) {
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            }
                            echo "<option value='$bulan1' $selected>$bulan[$i]</option>";
                        }
                        ?>
                    </select>
                </div> -->
                <div class="form-group col-md-2 col-12">
                    <label for="year">Year</label>
                    <select name="year" id="year" class="form-control">
                        <?php
                        $thn_skrng = date('Y');
                        for ($thn = $thn_skrng; $thn >= 2017; $thn--) {
                            echo "<option value='$thn'>$thn</option>";
                        }
                        ?>
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
    $('document').ready(function() {
        // var month = $("#month").val();
        var year = $("#year").val();
        view_data(year);

        $("#check").click(function() {
            // var month = $("#month").val();
            var year = $("#year").val();
            view_data(year);
        });
    });

    function view_data(year) {
        var param = $("#check");
        $.ajax({
            type: "POST",
            url: "<?php echo site_url(); ?>g_honda_after_sales/data",
            data: {
                year: year
            },
            beforeSend: function() {
                process1(param);
            },
            success: function(data) {
                $('#view').html(data);
                process_done1(param, '<i class="fa fa-check-square mr-1"></i> Check');
            }
        });
    }
</script>
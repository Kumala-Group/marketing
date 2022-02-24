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
            <label for="bulan">Month</label>
            <?php
            $bln_sekarang = (int) date('m');
            $nama_bln = array(1 => "January", "February", "March", "April", "	May", "June", "July", "August", "September", "October", "November", "December");
            ?>
                <select name="bln" id="bln" class="form-control">
                    <?php
                    for ($bln = 1; $bln <= 12; $bln++) {
                        if($bln==$bln_sekarang){
                            $selected='selected';
                        }else{
                            $selected='';
                        }
                        echo '<option value="' . str_pad($bln, 2, '0', STR_PAD_LEFT) . '" '.$selected.'>' . $nama_bln[$bln] . '</option>';
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
    $('document').ready(function(){   
        var bln = $("#bln").val();
        var thn = $("#thn").val();
        view_data(thn,bln);
        
        $("#check").click(function() {
            var bln = $("#bln").val();
            var thn = $("#thn").val();
            view_data(thn,bln);
           
        });
    });

    function view_data(thn,bln){
        var param = $("#check");
        $.ajax({
                type: "POST",
                url: "<?php echo site_url(); ?>g_wuling_financial_report/data",
                data: {
                    bln: bln,
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
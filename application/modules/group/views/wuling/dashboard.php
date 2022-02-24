<style>
.nav-link-home {
    font-size: 11pt;
    position: relative;
    color: #afadad !important;
    margin: 12px;
    box-shadow: inset 0px 1px 3px 1px #989898;
    background-color: white;
    border-radius: 7px !important;
    text-shadow: 0px 1px 2px;
    background-color: #f7f7f7;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#f7f7f7), to(#e7e7e7));
    background-image: -webkit-linear-gradient(top, #f7f7f7, #e7e7e7);
    background-image: -moz-linear-gradient(top, #f7f7f7, #e7e7e7);
    background-image: -ms-linear-gradient(top, #f7f7f7, #e7e7e7);
    background-image: -o-linear-gradient(top, #f7f7f7, #e7e7e7);
    transition: all 1s ease;
}
.nav-tabs .nav-link-home:focus, .nav-tabs .nav-link-home:hover {
     color:#FFF !important;box-shadow: 0px 3px 8px #aaa, inset 0px 2px 3px #fff;
    background-color: #f7f7f7;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#f71714), to(#941111));
    background-image: -webkit-linear-gradient(top, #f71714, #941111);
    background-image: -moz-linear-gradient(top, #f71714, #941111);
    background-image: -ms-linear-gradient(top, #f71714, #941111);
    background-image: -o-linear-gradient(top, #f71714, #941111);
}
.nav-tabs .nav-link {border: 0px solid transparent; }
.nav-tabs .nav-item.show .nav-link-home, .nav-tabs .nav-link-home.active {
    color:#FFF !important;box-shadow: 0px 3px 8px #aaa, inset 0px 2px 3px #fff;
    background-color: #f7f7f7;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#f71714), to(#941111));
    background-image: -webkit-linear-gradient(top, #f71714, #941111);
    background-image: -moz-linear-gradient(top, #f71714, #941111);
    background-image: -ms-linear-gradient(top, #f71714, #941111);
    background-image: -o-linear-gradient(top, #f71714, #941111);
}
</style>
<div class="mb-3 title-page"><i class="fa <?= $icon;?> title-page-icon"></i> <span class="title-page-text" style="color:<?= $color; ?>"><?php echo $title; ?></span><span class="title-page-text-2 ml-2"><?php echo $pt; ?></span></div>
<div class="row">
    <div class="col-lg-12 col-md-12 p-0 mt-md-0 mt-0">
    <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link nav-link-home" data-toggle="tab" href="#profil"><i class="fa fa-line-chart"></i> Sales Report</a></li>
                <li class="nav-item"><a class="nav-link nav-link-home" data-toggle="tab" href="#profil"><i class="fa fa-gears"></i> After Sales Report</a></li>
                <li class="nav-item"><a class="nav-link nav-link-home" data-toggle="tab" href="#profil"><i class="fa fa-bar-chart"></i> Marketing Report</a></li>
                <li class="nav-item"><a class="nav-link nav-link-home active show" data-toggle="tab" href="#akun"><i class="fa fa-money"></i> Financial Report</a></li>
                <li class="nav-item"><a class="nav-link nav-link-home" data-toggle="tab" href="#profil"><i class="fa fa-list-ul"></i> Login History</a></li>
              </ul>
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
                url: "<?php echo site_url(); ?>g_wuling/data",
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

<script>
    $('#loading').hide();
</script>
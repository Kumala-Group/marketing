<style>
h5{
    font-weight: 600;
    color: #f35032;
    text-shadow: 2px 1px 2px #9c9c9c;
    font-size: 16pt;
    margin-bottom: 20px;
}
</style>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 p-0 mt-md-2 mt-2">   
    <form>
        <div class="form-row">
            <div class="form-group col-md-2 col-12">
            <label for="jd">Job Desc</label>
                <select name="jd" id="jd" class="form-control">
                    <?php
                    $jd=array("n"=>"Sales","s"=>"Supervisor","sm"=>"Sales Manager");
                    foreach($jd as $k_jd=>$v_jd){
                        echo '<option value="'.$k_jd.'">'.$v_jd.'</option>';
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
        var jd = $("#jd").val();
        view_data(jd);
        
        $("#check").click(function() {
            var jd = $("#jd").val();
            view_data(jd);
           
        });
    });

    function view_data(jd){
        var param = $("#check");
        $.ajax({
                type: "POST",
                url: "<?php echo site_url(); ?>g_wuling_login_history_report/data",
                data: {
                    jd: jd
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
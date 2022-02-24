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
                <li class="nav-item"><a class="nav-link nav-link-home active show" onclick="loadPageInner('g_wuling_sales_report');" data-toggle="tab" href="#"><i class="fa fa-line-chart"></i> Sales Report</a></li>
                <li class="nav-item"><a class="nav-link nav-link-home" onclick="loadPageInner('g_wuling_after_sales_report');" data-toggle="tab" href="#"><i class="fa fa-gears"></i> After Sales Report</a></li>
                <li class="nav-item"><a class="nav-link nav-link-home" data-toggle="tab" href="#"><i class="fa fa-bar-chart"></i> Marketing Report</a></li>
                <li class="nav-item"><a class="nav-link nav-link-home" onclick="loadPageInner('g_wuling_financial_report');" data-toggle="tab" href="#"><i class="fa fa-money"></i> Financial Report</a></li>
                <li class="nav-item"><a class="nav-link nav-link-home" data-toggle="tab" onclick="loadPageInner('g_wuling_login_history_report');"  href="#"><i class="fa fa-list-ul"></i> Login History</a></li>
              </ul>
    </div>
</div>
<div id="space_content">

</div>
<script>
    $('#loading').hide();
</script>
<script>
    $('document').ready(function(){
    loadPageInner('g_wuling_sales_report');
    });
</script>
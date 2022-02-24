<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Robust admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, robust admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Kumala Group</title>
    <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url() ?>assets/robust/app-assets/images/ico/apple-icon-60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() ?>assets/robust/app-assets/images/ico/apple-icon-76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url() ?>assets/robust/app-assets/images/ico/apple-icon-120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url() ?>assets/robust/app-assets/images/ico/apple-icon-152.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>assets/img_marketing/img/logo.png">
    <link rel="shortcut icon" type="image/png" href="<?= base_url() ?>assets/img_marketing/img/logo.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/robust/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/robust/app-assets/fonts/icomoon.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/robust/app-assets/fonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/robust/app-assets/vendors/css/extensions/pace.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/robust/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/robust/app-assets/css/app.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/robust/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/robust/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/robust/app-assets/css/core/menu/menu-types/vertical-overlay-menu.css">

    <script src="<?= base_url() ?>assets/robust/app-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?= base_url() ?>assets/img_marketing/dist/themes/default/style.min.css">
    <script src="<?= base_url() ?>assets/img_marketing/dist/jstree.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/r-2.2.5/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/r-2.2.5/datatables.min.js"></script>
    <!-- <link href="< ?= base_url() ?>assets/img_marketing/dist/summernote.min.css" rel="stylesheet"> -->
    <!-- <link href="< ?= base_url() ?>assets/img_marketing/dist/datepicker.css" rel="stylesheet"> -->
    <link href="<?= base_url() ?>assets/robust/app-assets/vendors/css/extensions/bootstrap-datepicker3.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <!--switchery -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/robust/app-assets/vendors/css/switchery/switchery.min.css') ?>">
    <!--sweetalert -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/robust/app-assets/vendors/css/extensions/sweetalert.css') ?>">

    <!-- HighChart -->
    <script type="text/javascript" src="<?= base_url('assets/robust/app-assets/vendors/js/highchart/loader.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/robust/app-assets/vendors/js/highchart/code/highcharts.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/robust/app-assets/vendors/js/highchart/code/modules/data.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/robust/app-assets/vendors/js/highchart/code/modules/exporting.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/robust/app-assets/vendors/js/highchart/code/modules/accessibility.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/robust/app-assets/vendors/js/highchart/code/modules/export-data.js') ?>"></script>
    <style>
        .error {
            padding-top: 5px;
            color: #DA4453;
        }
    </style>
</head>
<style>
    /* .main-menu.menu-fixed {
        position: fixed;
        height: 100%;
        top: 0rem;
        height: 100%;
        z-index: 10000;
    } */

    .select2-container--classic .select2-selection--single,
    .select2-container--default .select2-selection--single {
        height: 37px !important;
        padding: 3px;
        border-color: #D9D9D9 !important;
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 26px;
        position: absolute;
        top: 6px;
        right: 1px;
        width: 20px;
        /* width: 20px; */
    }
</style>

<body data-open="click" data-menu="vertical-menu" data-col="2-columns" class="vertical-layout vertical-menu 2-columns fixed-navbar">
    <nav class="header-navbar navbar navbar-with-menu navbar-fixed-top navbar-semi-dark navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav">
                    <li class="nav-item mobile-menu hidden-md-up float-xs-left">
                        <a class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5 font-large-1"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="navbar-brand nav-link"><img alt="branding logo" src="<?= base_url() ?>assets/img_marketing/img/kumala.png" data-expand="<?= base_url() ?>assets/img_marketing/img/kumala.png" data-collapse="<?= base_url() ?>assets/img_marketing/img/logo.png" class="brand-logo"></a>
                    </li>
                    <li class="nav-item hidden-md-up float-xs-right">
                        <a data-toggle="collapse" data-target="#navbar-mobile" class="nav-link open-navbar-container"><i class="icon-ellipsis pe-2x icon-icon-rotate-right-right"></i></a>
                    </li>
                </ul>
            </div>
            <div class="navbar-container content container-fluid">
                <div id="navbar-mobile" class="collapse navbar-toggleable-sm">
                    <ul class="nav navbar-nav">
                        <li class="nav-item hidden-sm-down"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5"> </i></a></li>
                    </ul>
                    <ul class="nav navbar-nav float-xs-right">
                        <li class="dropdown dropdown-notification nav-item">
                            <select id="brand" name="brand" class="form-control" style="margin-top: 13px;" data-toggle="tooltip" data-trigger="hover" data-placement="top">
                                <option value="">-- Pilih Brand --</option>
                                <?php
                                $qb = $this->model_konfigurasi_user->view_data_brand();
                                $id_brand_view = $this->model_konfigurasi_user->GetIdBrand();
                                foreach ($qb->result() as $db) {
                                ?>
                                    <option value="<?= $db->id_brand ?>" <?= ($db->id_brand == $id_brand_view ? "selected" : "") ?>><?= $db->nama_brand ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </li>
                        <li class="dropdown dropdown-notification nav-item">
                            <a href="javascript:void(0)" data-toggle="dropdown" class="nav-link nav-link-label">
                                <i class="ficon icon-bell4"></i><span class="tag tag-pill tag-default tag-danger tag-default tag-up counter"></span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <h6 class="dropdown-header m-0"><span class="grey darken-2">Notifikasi</span>
                                        <span class="notification-tag tag tag-default tag-danger float-xs-right m-0 counter"></span></h6>
                                </li>
                                <li class="list-group scrollable-container" id="notifikasi"></li>
                                <li class="dropdown-menu-footer" style="display: none;">
                                    <a href="<?= base_url("notifikasi") ?>" class="dropdown-item text-muted text-xs-center">Lihat semua notifikasi</a></li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-user nav-item"><a href="javascript:void(0)" data-toggle="dropdown" class="dropdown-toggle nav-link dropdown-user-link">
                                <span class="avatar avatar-online"><img src="<?= base_url() ?>assets/robust/app-assets/images/portrait/small/avatar-s-1.png" alt="avatar"></span>
                                <span class="user-name"><?= $this->session->userdata('nama_lengkap') ?></span></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="<?= base_url() ?>kumalagroup/logout" class="dropdown-item"><i class="icon-power3"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <?= $this->view('menu') ?>
    <div class="app-content content container-fluid">
        <div class="content-wrapper">
            <div class="content-body">
                <?= $this->view($content) ?>
            </div>
        </div>
    </div>
    <script src="<?= base_url() ?>assets/robust/app-assets/vendors/js/ui/tether.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/robust/app-assets/js/core/libraries/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/robust/app-assets/vendors/js/ui/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/robust/app-assets/vendors/js/ui/unison.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/robust/app-assets/vendors/js/ui/blockUI.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/robust/app-assets/vendors/js/ui/jquery.matchHeight-min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/robust/app-assets/vendors/js/ui/screenfull.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/robust/app-assets/vendors/js/extensions/pace.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/robust/app-assets/js/core/app-menu.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/robust/app-assets/js/core/app.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/img_marketing/dist/sweetalert.min.js"></script>
    <script src="<?= base_url() ?>assets/img_marketing/dist/jquery.validate.min.js"></script>
    <!-- <script src="< ?= base_url() ?>assets/img_marketing/dist/summernote.min.js"></script> -->
    <!-- <script src="< ?= base_url() ?>assets/img_marketing/dist/bootstrap-datepicker.js"></script> -->
    <script src="<?= base_url('assets/robust/app-assets/vendors/js/extensions/bootstrap-datepicker.min.js') ?>"></script>
    <script src="<?= base_url('assets/robust/app-assets/vendors/js/extensions/bootstrap-datepicker.id.min.js') ?>"></script>
    <!--switchery -->
    <script src="<?= base_url('assets/robust/app-assets/vendors/js/switchery/bootstrap-switch.min.js') ?>"></script>
    <script src="<?= base_url('assets/robust/app-assets/vendors/js/switchery/bootstrap-checkbox.min.js') ?>"></script>
    <script src="<?= base_url('assets/robust/app-assets/vendors/js/switchery/switchery.min.js') ?>"></script>
    <script src="<?= base_url('assets/robust/app-assets/vendors/js/switchery/switch.min.js') ?>"></script>
    <script>
        $(document).ready(function() {
            $("#brand").change(function() {
                var brand = $("#brand").val();
                loading_content_body();
                $.post("<?= base_url(); ?>kumalagroup_home/update_id_brand_view", {
                        'brand': brand,
                    },
                    function(data) {
                        // location.reload();
                        unload_content_body();
                    }, );
            });
        });
        // $('.table_aplikasi').DataTable({
        //     "ordering": false
        // });
        $('#tanggal').datepicker({
            'format': 'dd-mm-yyyy'
        });
        // $('.summernote').summernote();

        // var html = "";
        // refresh_notifikasi();
        // setInterval(function() {
        //     html = "";
        //     refresh_notifikasi();
        // }, (60 * 1000));

        $('a[data-toggle="tab"]').on('show.bs.tab', function() {
            if ($(this).attr('href') != "#tab1")
                localStorage.setItem('active', $(this).attr('href'));
        });
        var active = localStorage.getItem('active');
        if (active) $('.nav-tabs a[href="' + active + '"]').tab('show');


        function input_number(e) {
            if ($.inArray(e.which, [187, 107, 8, 37, 39, 46, 190]) != -1) return;
            else if ((e.which < 48 || e.which > 57) && (e.which < 96 || e.which > 105)) e.preventDefault();
        }

        function format_rupiah(e) {
            var number_string = e.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                r = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            if (ribuan) {
                separator = sisa ? '.' : '';
                r += separator + ribuan.join('.');
            }
            return r;
        }

        // function refresh_notifikasi() {
        //     $.post("< ?= base_url("notifikasi") ?>", {
        //         'load': true
        //     }, function(r) {
        //         $('.counter').html(r.count + " Baru");
        //         if (r.notifikasi == undefined) {
        //             html = '<a href="javascript:void(0)" class="list-group-item"><p class="notification-text text-muted m-0">Tidak ada notifikasi untuk saat ini.</p></a>';
        //             $('.dropdown-menu-footer').css('display', "none");
        //         } else {
        //             $.each(r.notifikasi, function(key, v) {
        //                 var status = v.status == 1 ? "text-muted" : "";
        //                 html += '<a href="javascript:void(0)" onclick="update_notifikasi(' + v.id + ',`< ?= base_url() ?>' + v.link + '`);" class="list-group-item"><div class="media"><div class="media-body"><h6 class="media-heading ' + status + '">' + v.kategori + '</h6><p class="notification-text font-small-3 text-muted">' + v.deskripsi + '</p><small><time class="media-meta text-muted">' + v.time + '</time></small> </div> </div> </a>';
        //             });
        //             $('.dropdown-menu-footer').removeAttr("style");
        //         }
        //         $('#notifikasi').html(html);
        //     }, "json");
        // }

        // function update_notifikasi(id, link) {
        //     $.post("< ?= base_url("notifikasi") ?>", {
        //         'update': true,
        //         'id': id
        //     }, function() {
        //         location = link;
        //     });
        // }

        function loading() {
            $('.form-body').block({
                message: '<div class="icon-spinner9 icon-spin icon-lg"></div>',
                overlayCSS: {
                    backgroundColor: '#FFF',
                    cursor: 'wait',
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'none'
                }
            });
            $('#submit').prop('disabled', true);
            $('#submit').html('<i class="icon-check2"></i> Loading...');
        }

        function modal_loading() {
            $('.modal-body').block({
                message: '<div class="icon-spinner9 icon-spin icon-lg"></div>',
                overlayCSS: {
                    backgroundColor: '#FFF',
                    cursor: 'wait',
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'none'
                }
            });
            $('#simpan_detail').prop('disabled', true);
            $('#simpan_detail').html('<i class="icon-check2"></i> Loading...');
        }

        function loading_content_body() {
            $('.content-body').block({
                message: '<div class="icon-spinner9 icon-spin icon-lg"></div>',
                overlayCSS: {
                    backgroundColor: '#FFF',
                    cursor: 'progress',
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'none'
                }
            });
            $('#cari_data').prop('disabled', true);
            $('#cari_data').html('<i class="icon-search"></i> Loading...');
        }

        function unload() {
            $('.form-body').unblock();
            $('#submit').prop('disabled', false);
            $('#submit').html('<i class="icon-check2"></i> Simpan');
        }

        function modal_unload() {
            $('.modal-body').unblock();
            $('#simpan_detail').prop('disabled', false);
            $('#simpan_detail').html('<i class="icon-check2"></i> Simpan');
        }

        function unload_content_body() {
            location.reload();
            $('.content-body').unblock();
            $('#cari_data').prop('disabled', false);
            $('#cari_data').html('<i class="icon-search"></i> Cari Data');
        }
    </script>
</body>

</html>